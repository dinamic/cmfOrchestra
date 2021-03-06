<?php
/**
 * This file is part of the <PI_CRUD> project.
 *
 * @category   PI_CRUD_Controllers
 * @package    Controller
 * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>
 * @since XXXX-XX-XX
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PiApp\GedmoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BootStrap\TranslationBundle\Controller\abstractController;
use PiApp\AdminBundle\Exception\ControllerException;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use JMS\SecurityExtraBundle\Annotation\Secure;

use PiApp\GedmoBundle\Entity\Partner;
use PiApp\GedmoBundle\Form\PartnerType;
use PiApp\GedmoBundle\Entity\Translation\PartnerTranslation;

/**
 * Partner controller.
 *
 *
 * @category   PI_CRUD_Controllers
 * @package    Controller
 *
 * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>
 */
class PartnerController extends abstractController
{
	protected $_entityName = "PiAppGedmoBundle:Partner";

	/**
     * Enabled Partner entities.
     *
     * @Route("/admin/gedmo/partenaires/enabled", name="admin_gedmo_partner_enabledentity_ajax")
     * @Secure(roles="ROLE_USER")
	 * @return \Symfony\Component\HttpFoundation\Response
     *     
     * @access  public
     * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>
     */
    public function enabledajaxAction()
    {
    	return parent::enabledajaxAction();
    }

    /**
     * Disable Partner entities.
     * 
     * @Route("/admin/gedmo/partenaires/disable", name="admin_gedmo_partner_disablentity_ajax")
     * @Secure(roles="ROLE_USER")
	 * @return \Symfony\Component\HttpFoundation\Response
     *     
     * @access  public
     * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>
     */
    public function disableajaxAction()
    {
		return parent::disableajaxAction();
    } 

	/**
     * Change the position of a Partner entity.
     *
     * @Route("/admin/gedmo/partenaires/position", name="admin_gedmo_partner_position_ajax")
     * @Secure(roles="ROLE_USER")
	 * @return \Symfony\Component\HttpFoundation\Response
     *     
     * @access  public
     * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>
     */
    public function positionajaxAction()
    {
    	return parent::positionajaxAction();
    }   

	/**
     * Delete a Partner entity.
     *
     * @Route("/admin/gedmo/partenaires/delete", name="admin_gedmo_partner_deletentity_ajax")
     * @Secure(roles="ROLE_USER")
	 * @return \Symfony\Component\HttpFoundation\Response
     *     
     * @access  public
     * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>
     */
    public function deleteajaxAction()
    {
    	return parent::deletajaxAction();
    }   
    
    /**
     * Archive a Partner entity.
     *
     * @Route("/admin/gedmo/partenaires/archive", name="admin_gedmo_partenaires_archiveentity_ajax")
     * @Secure(roles="ROLE_USER")
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @access  public
     * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>
     */
    public function archiveajaxAction()
    {
    	return parent::archiveajaxAction();
    }
        
    /**
     * Lists all Partner entities.
     *
     * @Secure(roles="IS_AUTHENTICATED_ANONYMOUSLY")
	 * @return \Symfony\Component\HttpFoundation\Response
     *
	 * @access	public
	 * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>   
     */
    public function indexAction()
    {
        $em			= $this->getDoctrine()->getEntityManager();
        $locale		= $this->container->get('session')->getLocale();
        
        $category   = $this->container->get('request')->query->get('category');
        $NoLayout   = $this->container->get('request')->query->get('NoLayout');
        if(!$NoLayout) 	$template = "index.html.twig"; else $template = "index.html.twig";
        
        if($NoLayout){
        	//$entities 	= $em->getRepository("PiAppGedmoBundle:Partner")->getAllEnableByCatAndByPosition($locale, $category, 'object');
        	$query		= $em->getRepository("PiAppGedmoBundle:Partner")->getAllByCategory($category, null, '', 'ASC', false)->getQuery();
        	$entities   = $em->getRepository("PiAppGedmoBundle:Partner")->findTranslationsByQuery($locale, $query, 'object', false);
        }else
        	$entities	= $em->getRepository("PiAppGedmoBundle:Partner")->findAllByEntity($locale, 'object');        

        return $this->render("PiAppGedmoBundle:Partner:$template", array(
            'entities' => $entities,
            'NoLayout'	=> $NoLayout,
            'category'	=> $category,          
        ));
    }

    /**
     * Finds and displays a Partner entity.
     *
     * @Secure(roles="IS_AUTHENTICATED_ANONYMOUSLY")
	 * @return \Symfony\Component\HttpFoundation\Response
     *
	 * @access	public
	 * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>    
     */
    public function showAction($id)
    {
        $em 	= $this->getDoctrine()->getEntityManager();
        $locale	= $this->container->get('session')->getLocale();
        $entity = $em->getRepository("PiAppGedmoBundle:Partner")->findOneByEntity($locale, $id, 'object');
        
        $NoLayout   = $this->container->get('request')->query->get('NoLayout');
        $category   = $this->container->get('request')->query->get('category');
        if(!$NoLayout) 	$template = "show.html.twig"; else $template = "show.html.twig";        

        if (!$entity) {
            throw ControllerException::NotFoundException('Partner');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render("PiAppGedmoBundle:Partner:$template", array(
            'entity'      => $entity,
            'NoLayout'	  => $NoLayout,
            'delete_form' => $deleteForm->createView(),
            'category'	=> $category,   
        ));
    }

    /**
     * Displays a form to create a new Partner entity.
     *
     * @Secure(roles="ROLE_USER")
	 * @return \Symfony\Component\HttpFoundation\Response
     *
	 * @access	public
	 * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>    
     */
    public function newAction()
    {
    	$em 	= $this->getDoctrine()->getEntityManager();
    	$entity = new Partner();
        $form   = $this->createForm(new PartnerType($em, $this->container), $entity, array('show_legend' => false));
        
        $NoLayout   = $this->container->get('request')->query->get('NoLayout');
        $category   = $this->container->get('request')->query->get('category');
        if(!$NoLayout)	$template = "new.html.twig";  else 	$template = "new.html.twig";        

        return $this->render("PiAppGedmoBundle:Partner:$template", array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'NoLayout'  => $NoLayout,
            'category'	=> $category,             
        ));
    }

    /**
     * Creates a new Partner entity.
     *
     * @Secure(roles="ROLE_USER")
     * @return \Symfony\Component\HttpFoundation\Response
     *
	 * @access	public
	 * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>     
     */
    public function createAction()
    {
        $em 	= $this->getDoctrine()->getEntityManager();
        $locale	= $this->container->get('session')->getLocale();
        
        $NoLayout   = $this->container->get('request')->query->get('NoLayout');
        $category   = $this->container->get('request')->query->get('category');
        if(!$NoLayout)	$template = "new.html.twig";  else 	$template = "new.html.twig";        
    
        $entity  = new Partner();
        $request = $this->getRequest();
        $form    = $this->createForm(new PartnerType($em, $this->container), $entity, array('show_legend' => false));
        $form->bindRequest($request);

        if ($form->isValid()) {
            $entity->setTranslatableLocale($locale);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_gedmo_partner_show', array('id' => $entity->getId(), 'NoLayout' => $NoLayout, 'category' => $category)));
                        
        }

        return $this->render("PiAppGedmoBundle:Partner:$template", array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'NoLayout'  => $NoLayout,
            'category'	=> $category,             
        ));
    }

    /**
     * Displays a form to edit an existing Partner entity.
     *
     * @Secure(roles="ROLE_USER")
	 * @return \Symfony\Component\HttpFoundation\Response
     *
	 * @access	public
	 * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>    
     */
    public function editAction($id)
    {
        $em 	= $this->getDoctrine()->getEntityManager();
    	$locale	= $this->container->get('session')->getLocale();
        $entity = $em->getRepository("PiAppGedmoBundle:Partner")->findOneByEntity($locale, $id, 'object');
        
        $NoLayout   = $this->container->get('request')->query->get('NoLayout');
        $category   = $this->container->get('request')->query->get('category');
        if(!$NoLayout)	$template = "edit.html.twig";  else	$template = "edit.html.twig";        

        if (!$entity) {
        	$entity = $em->getRepository("PiAppGedmoBundle:Partner")->find($id);
        	$entity->addTranslation(new PartnerTranslation($locale));            
        }

        $editForm   = $this->createForm(new PartnerType($em, $this->container), $entity, array('show_legend' => false));
        $deleteForm = $this->createDeleteForm($id);

        return $this->render("PiAppGedmoBundle:Partner:$template", array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'NoLayout' 	  => $NoLayout,
            'category'	=> $category,             
        ));
    }

    /**
     * Edits an existing Partner entity.
     *
     * @Secure(roles="ROLE_USER")
	 * @return \Symfony\Component\HttpFoundation\Response
     *
	 * @access	public
	 * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>   
     */
    public function updateAction($id)
    {
        $em 	= $this->getDoctrine()->getEntityManager();
    	$locale	= $this->container->get('session')->getLocale();
        $entity = $em->getRepository("PiAppGedmoBundle:Partner")->findOneByEntity($locale, $id, "object"); 
        
        $NoLayout   = $this->container->get('request')->query->get('NoLayout');
        $category   = $this->container->get('request')->query->get('category');
        if(!$NoLayout)	$template = "edit.html.twig";  else	$template = "edit.html.twig";        

        if (!$entity) {
        	$entity = $em->getRepository("PiAppGedmoBundle:Partner")->find($id);
        }

        $editForm   = $this->createForm(new PartnerType($em, $this->container), $entity, array('show_legend' => false));
        $deleteForm = $this->createDeleteForm($id);

        $editForm->bindRequest($this->getRequest(), $entity);
        if ($editForm->isValid()) {
            $entity->setTranslatableLocale($locale);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_gedmo_partner_edit', array('id' => $id, 'NoLayout' => $NoLayout, 'category' => $category)));
        }

        return $this->render("PiAppGedmoBundle:Partner:$template", array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'NoLayout' 	  => $NoLayout,
            'category'	=> $category,             
        ));
    }

    /**
     * Deletes a Partner entity.
     *
     * @Secure(roles="ROLE_USER")
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *     
	 * @access	public
	 * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>     
     */
    public function deleteAction($id)
    {
        $em 	 = $this->getDoctrine()->getEntityManager();
	    $locale	 = $this->container->get('session')->getLocale();
	    
	    $NoLayout   = $this->container->get('request')->query->get('NoLayout');	
      	$category   = $this->container->get('request')->query->get('category');
    
        $form 	 = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
    	    $entity = $em->getRepository("PiAppGedmoBundle:Partner")->findOneByEntity($locale, $id, 'object');

            if (!$entity) {
                throw ControllerException::NotFoundException('Partner');
            }

        	try {
            	$em->remove($entity);
            	$em->flush();
            } catch (\Exception $e) {
            	$this->container->get('session')->setFlash('notice', 'pi.session.flash.wrong.undelete');
            }
        }

        return $this->redirect($this->generateUrl('admin_gedmo_partenaires', array('NoLayout' => $NoLayout, 'category' => $category)));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    /**
     * Template : Finds and displays a Partner entity.
     * 
     * @Cache(maxage="86400")
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @access	public
     * @author Etienne de Longeaux <etienne.delongeaux@gmail.com> 
     */
    public function _template_showAction($id, $template = '_tmp_show.html.twig', $lang = "")
    {
    	$em 	= $this->getDoctrine()->getEntityManager();
    	
    	if(empty($lang))
    		$lang	= $this->container->get('session')->getLocale();
    		
    	$entity = $em->getRepository("PiAppGedmoBundle:Partner")->findOneByEntity($lang, $id, 'object', false);
    	
    	if (!$entity) {
    		throw ControllerException::NotFoundException('Partner');
    	}
    	
    	if(method_exists($entity, "getTemplate") && $entity->getTemplate() != "")
    		$template = $entity->getTemplate();     	
    
    	return $this->render("PiAppGedmoBundle:Partner:$template", array(
    			'entity'	=> $entity,
    			'locale'	=> $lang,
    	));
    }

	/**
     * Template : Finds and displays a list of Partner entity.
     * 
     * @Cache(maxage="86400")
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @access	public
     * @author Etienne de Longeaux <etienne.delongeaux@gmail.com> 
     */
    public function _template_listAction($category = '', $MaxResults = null, $template = '_tmp_list.html.twig', $order = 'DESC', $lang = "", $type='')
    {
    	$em 		= $this->getDoctrine()->getEntityManager();

    	if(empty($lang))
    		$lang	= $this->container->get('session')->getLocale();
    		
    	if(empty($type)){
    		$query		= $em->getRepository("PiAppGedmoBundle:Partner")->getAllByCategory($category, $MaxResults, '', $order)->getQuery();
        	$entities   = $em->getRepository("PiAppGedmoBundle:Partner")->findTranslationsByQuery($lang, $query, 'object', false);
       	}elseif($type == 'archive'){
       		$query			= $em->getRepository("PiAppGedmoBundle:Partner")->getAllByCategory($category, $MaxResults, '', $order)->getQuery();
        	$entities_all   = $em->getRepository("PiAppGedmoBundle:Partner")->findTranslationsByQuery($lang, $query, 'object', false);
        	
        	$entities = array();
        	foreach($entities_all as $key => $entity){
        		$cat = $entity->getCategory();
        		if($cat instanceof \PiApp\GedmoBundle\Entity\Category){
        			$entities[ $cat->getPosition() ]['partner'][] = $entity;
        			$entities[ $cat->getPosition() ]['name']	  = $cat->getName();
        		}
        	}
        	
        	ksort($entities);
        	
    	}elseif($type == 'highlighted1'){
    		$entities	= $em->getRepository("PiAppGedmoBundle:Partner")->findBy(array('highlighted1'=>true, 'enabled'=>true), array('title'=>$order), $MaxResults);
    	}elseif($type == 'highlighted2'){
    		$entities	= $em->getRepository("PiAppGedmoBundle:Partner")->findBy(array('highlighted2'=>true, 'enabled'=>true), array('title'=>$order), $MaxResults);
    	}elseif($type == 'highlighted3'){
    		$entities	= $em->getRepository("PiAppGedmoBundle:Partner")->findBy(array('highlighted3'=>true, 'enabled'=>true), array('title'=>$order), $MaxResults);
    	}         

        return $this->render("PiAppGedmoBundle:Partner:$template", array(
            'entities' => $entities,
            'cat'	   => ucfirst($category),
        	'locale'   => $lang,
        ));
    }     
    
    /**
     * Template : Finds and displays a list of Partner entity.
     *
     * @Cache(maxage="86400")
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @access	public
     * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>
     */
    public function _template_annuaireAction($template = '_tmp_list.html.twig', $order = 'DESC', $lang = "")
    {
    	$em 		= $this->getDoctrine()->getEntityManager();
    
    	if(empty($lang))
    		$lang	= $this->container->get('session')->getLocale();
    
    	$adh_fixe	= $em->getRepository("PiAppGedmoBundle:Partner")->findBy(array('highlighted1'=>true, 'enabled'=>true), array('title'=>$order), 4);
    	$adh_alea	= $em->getRepository("PiAppGedmoBundle:Partner")->findBy(array('highlighted2'=>true, 'enabled'=>true), array('title'=>$order), 12);
    	
    	return $this->render("PiAppGedmoBundle:Partner:$template", array(
    			'adh_fixe' => $adh_fixe,
    			'adh_alea' => $adh_alea,
    			'locale'   => $lang,
    	));
    }    
    
}
