<?php


namespace Rz\CategoryPageBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sonata\AdminBundle\Form\Type\Filter\ChoiceType;

/**
 * Page Admin Controller.
 *
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
class CategoryHasPageAdminController extends Controller
{

    //    /**
//     * @param Request $request
//     *
//     * @return \Symfony\Component\HttpFoundation\Response
//     */
//    public function listAction(Request $request = null)
//    {
//
//        if (!$request->get('filter') && !$request->get('filters')) {
//            return new RedirectResponse($this->admin->generateUrl('tree'));
//        }
//
//        if ($listMode = $request->get('_list_mode')) {
//            $this->admin->setListMode($listMode);
//        }
//
//        $categoryManager = $this->get('sonata.classification.manager.category');
//        $contextManager = $this->get('sonata.classification.manager.context');
//
//        $currentContext = null;
//        $filters = $request->get('filter');
//
//        if($filters && array_key_exists('context', $filters) && $filters['context']['value']) {
//            $currentContext = $contextManager->find($filters['context']['value']);
//        } elseif ($context = $request->get('context')) {
//            $currentContext = $contextManager->find($context);
//        } else {
//            $currentContext = $contextManager->find($this->container->getParameter('rz.classification.category.default_context'));
//        }
//
//        $rootCategories = $categoryManager->getRootCategories(false);
//
//        if (!$currentContext) {
//            $mainCategory   = current($rootCategories);
//            $currentContext = $mainCategory->getContext();
//        } else {
//            foreach ($rootCategories as $category) {
//                if ($currentContext->getId() != $category->getContext()->getId()) {
//                    continue;
//                }
//
//                $mainCategory = $category;
//
//                break;
//            }
//        }
//
//        $datagrid = $this->admin->getDatagrid();
//
//        if ($currentContext) {
//            $datagrid->setValue('context', null, $currentContext->getId());
//        }
//
//        $formView = $datagrid->getForm()->createView();
//
//        // set the theme for the current Admin Form
//        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());
//
//        return $this->render($this->admin->getTemplate('list'), array(
//            'action'     => 'list',
//            'main_category'    => $mainCategory,
//            'root_categories'  => $rootCategories,
//            'current_context'  => $currentContext,
//            'form'       => $formView,
//            'datagrid'   => $datagrid,
//            'csrf_token' => $this->getCsrfToken('sonata.batch'),
//        ));
//    }
//
//    /**
//     * @param Request $request
//     *
//     * @return Response
//     */
//    public function treeAction(Request $request)
//    {
//        $categoryManager = $this->get('sonata.classification.manager.category');
//        $contextManager  = $this->get('sonata.classification.manager.context');
//        $defaultContext  = $this->container->getParameter('rz.classification.category.default_context');
//
//        $currentContext = false;
//        if ($context = $request->get('context')) {
//            $currentContext = $contextManager->find($context);
//        } else {
//            $currentContext = $contextManager->find($defaultContext);
//        }
//
//        $rootCategories = $categoryManager->getRootCategories(false);
//
//        $mainCategory = null;
//
//        if (!$currentContext) {
//            $mainCategory   = current($rootCategories);
//            $currentContext = $mainCategory->getContext();
//        } else {
//            foreach ($rootCategories as $category) {
//                if ($currentContext->getId() != $category->getContext()->getId()) {
//                    continue;
//                }
//
//                $mainCategory = $category;
//
//                break;
//            }
//        }
//
//        if(!$mainCategory) {
//            $mainCategory = $categoryManager->generateParentCategory($currentContext, $defaultContext);
//        }
//
//        $datagrid = $this->admin->getDatagrid();
//
//        if ($currentContext) {
//            $datagrid->setValue('context', null, $currentContext->getId());
//        }
//
//        $formView = $datagrid->getForm()->createView();
//
//        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());
//
//        return $this->render('RzClassificationBundle:CategoryAdmin:tree.html.twig', array(
//            'action'           => 'tree',
//            'main_category'    => $mainCategory,
//            'root_categories'  => $rootCategories,
//            'current_context'  => $currentContext,
//            'form'             => $formView,
//            'csrf_token'       => $this->getCsrfToken('sonata.batch'),
//        ));
//    }
}
