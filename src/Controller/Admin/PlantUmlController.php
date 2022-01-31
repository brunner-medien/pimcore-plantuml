<?php

namespace PlantUmlBundle\Controller\Admin;

use PlantUmlBundle\Service\GeneratorServiceInterface;
use PlantUmlBundle\Service\ConfigurationServiceInterface;
use PlantUmlBundle\Model\ConfigInterface;
use PlantUmlBundle\Model\ModelInterface;
use Pimcore\Bundle\AdminBundle\Controller\AdminController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use function Jawira\PlantUml\encodep;

class PlantUmlController extends AdminController
{

    /**
     * @param Request $request
     * @param GeneratorServiceInterface $generatorService
     * @param ConfigurationServiceInterface $configurationService
     *
     * @return JsonResponse
     *
     * @Route("/generate", name="plantuml_admin_generate", methods={"GET"})
     */
    public function generateAction(
        Request $request,
        GeneratorServiceInterface $generatorService,
        ConfigurationServiceInterface $configurationService
    )
    {
        $success = true;
        $message = null;
        $puml = '';
        $renderUrl = '';

        try {
            $this->checkAdminUser();
            $name = $request->get('name', '');
            $config = $configurationService->getConfig($name);
            $puml = $generatorService->generate($config, $name);
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        try {
            $renderUrl = sprintf("%s%s", $configurationService->getRenderUrl(), encodep($puml));
        } catch (\Exception $e) {
            // silently ignore
        }

        return new JsonResponse((object) [
            'puml' => $puml,
            'success' => $success,
            'message' => $message,
            'renderUrl' => $renderUrl
        ]);
    }

    /**
     * @param Request $request
     * @param GeneratorServiceInterface $generatorService
     * @param ConfigurationServiceInterface $configurationService
     *
     * @return JsonResponse
     *
     * @Route("/config_get", name="plantuml_admin_config_get", methods={"GET"})
     */
    public function getConfigAction(
        Request $request,
        GeneratorServiceInterface $generatorService,
        ConfigurationServiceInterface $configurationService
    )
    {
        $success = true;
        $message = null;
        $classes = $settings = null;

        try {

            $this->checkAdminUser();
            $config = $configurationService->getConfig($request->get('name', ''));

            $registry = $generatorService->loadRegistry();
            $classes = $this->generateClassTree(
                $this->generateNamespaceTree($registry->getClasses()),
                $config
            );

            $settings = $config->toArray();
            unset($settings['classStates']);

        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return new JsonResponse((object) [
            'classTree' => $classes,
            'settings' => $settings,
            'success' => $success,
            'message' => $message
        ]);
    }

    /**
     * @param ConfigurationServiceInterface $configurationService
     *
     * @return JsonResponse
     *
     * @Route("/templates_list", name="plantuml_admin_templates_list", methods={"GET"})
     */
    public function listTemplatesAction(ConfigurationServiceInterface $configurationService)
    {
        $templates = [];

        try {
            $this->checkAdminUser();
            foreach ($configurationService->getTemplates() as $name => $path) {
                $templates[] = [
                    'name' => $name,
                    'value' => $name
                ];
            }
        } catch (\Exception $e) {
            // do nothing but return an empty list
        }

        return new JsonResponse((object) [
            'templates' => $templates
        ]);
    }

    /**
     * @param Request $request
     * @param ConfigurationServiceInterface $configurationService
     *
     * @return JsonResponse
     *
     * @Route("/config_list", name="plantuml_admin_config_list", methods={"GET"})
     */
    public function listConfigAction(Request $request, ConfigurationServiceInterface $configurationService)
    {
        $configs = [];

        try {
            $this->checkAdminUser();
            $configs = $configurationService->listConfig();
        } catch (\Exception $e) {
            // do nothing but return an empty list
        }

        return new JsonResponse((object) [
            'config' => $configs
        ]);
    }

    /**
     * @param Request $request
     * @param ConfigurationServiceInterface $configurationService
     *
     * @return JsonResponse
     *
     * @Route("/config_delete", name="plantuml_admin_config_delete", methods={"POST"})
     */
    public function deleteConfigAction(Request $request, ConfigurationServiceInterface $configurationService)
    {
        $success = true;
        $message = null;

        try {
            $this->checkAdminUser();
            $configurationService->deleteConfig($request->request->get('name', ''));
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return new JsonResponse((object) [
            'success' => $success,
            'message' => $message
        ]);
    }

    /**
     * @param Request $request
     * @param ConfigurationServiceInterface $configurationService
     *
     * @return JsonResponse
     *
     * @Route("/config_create", name="plantuml_admin_config_create", methods={"POST"})
     */
    public function createConfigAction(Request $request, ConfigurationServiceInterface $configurationService)
    {
        $success = true;
        $message = null;

        try {
            $this->checkAdminUser();
            $configurationService->saveConfig($request->request->get('name', ''), [], false);
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return new JsonResponse((object) [
            'success' => $success,
            'message' => $message
        ]);
    }

    /**
     * @param Request $request
     * @param ConfigurationServiceInterface $configurationService
     *
     * @return JsonResponse
     *
     * @Route("/config_save", name="plantuml_admin_config_save", methods={"POST"})
     */
    public function saveConfigAction(Request $request, ConfigurationServiceInterface $configurationService)
    {
        $success = true;
        $message = null;

        try {
            $this->checkAdminUser();
            $data = $this->getRequestPayload($request);
            $configurationService->saveConfig($request->get('name', ''), $data, true);
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return new JsonResponse((object) [
            'success' => $success,
            'message' => $message
        ]);
    }

    /**
     * From a flat list of models, create a tree hierarchy based
     * on model namespaces.
     *
     * @param ModelInterface[] $models
     *
     * @return array
     */
    protected function generateNamespaceTree(array $models)
    {
        $tree = ['children' => []];
        foreach ($models as $model) {
            $scope = &$tree;
            foreach (array_merge($model->getNamespace(), [$model->getName()]) as $name) {
                if (!array_key_exists($name, $scope['children'])) {
                    $scope['children'][$name] = [
                        'model' => null,
                        'children' => []
                    ];
                }
                $scope = &$scope['children'][$name];
            }
            $scope['model'] = $model;
        }

        return $tree;
    }

    /**
     * From a tree hierarchy, generate Ext.data.TreeStore data
     *
     * @param array $tree
     * @param ConfigInterface $config
     *
     * @return array
     */
    protected function generateClassTree(array $tree, ConfigInterface $config)
    {
        $items = [];
        foreach ($tree['children'] as $name => $subtree) {
            $children = $this->generateClassTree($subtree, $config);
            $id = $subtree['model'] ? $subtree['model']->getNamespaceName() : $name;
            $seedable = $subtree['model'] && $subtree['model']->getIsSeedable();
            $items[] = [
                'id' => $id,
                'text' => $subtree['model'] ? $subtree['model']->getName() : $name,
                'seedable' => $seedable,
                'leaf' => sizeof($children) === 0,
                'children' => sizeof($children) > 0 ? $children : false,
                'seed' => $seedable ? $config->getClassSeed($id) : null,
                'mode' => $config->getClassMode($id)
            ];
        }

        return $items;
    }

    /**
     * Get payload data from request body or via form data.
     *
     * @param Request $request
     *
     * @return array|null
     */
    protected function getRequestPayload(Request $request)
    {
        $requestData = null;

        if (str_starts_with($request->headers->get('Content-Type'), 'application/json')) {
            $content = $request->getContent();
            if (!empty($content)) {
                $requestData = json_decode($content, true);
            }
        } else {
            $requestData = $request->request->all();
        }

        return $requestData;
    }

    /**
     * @return void
     */
    protected function checkAdminUser()
    {
        if (!$this->getAdminUser() || !$this->getAdminUser()->isAdmin()) {
            throw $this->createAccessDeniedHttpException();
        }
    }

}
