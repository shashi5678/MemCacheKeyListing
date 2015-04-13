<?php
/**
 * Mem Controller
 */
namespace MemListing\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    /**
     * Action for Listing cached keys
     * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
     */
    public function indexAction()
    {
        $memObj = $this->getServiceLocator()->get('MemListingService');
        $memKeys = $memObj->getMemcacheKeys();
        return new ViewModel(array(
            'memKeys' => $memKeys
        ));
    }

    /**
     * Deleting cached key
     * @return Ambigous <\Zend\Http\Response, \Zend\Stdlib\ResponseInterface>
     */
    
    public function deleteAction()
    {
        $key = $this->params()->fromPost('key');
        $memListingService = $this->getServiceLocator()->get('MemListingService');
        $memListingService->deleteKey($key);
        return $this->redirect()->toRoute('mem', array(
            'action' => 'index'
        ));
    }
}
