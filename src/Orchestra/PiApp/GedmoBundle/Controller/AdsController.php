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

use PiApp\GedmoBundle\Entity\Ads;
use PiApp\GedmoBundle\Form\AdsType;
use PiApp\GedmoBundle\Entity\Translation\AdsTranslation;

/**
 * Ads controller.
 *
 *
 * @category   PI_CRUD_Controllers
 * @package    Controller
 *
 * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>
 */
class AdsController extends abstractController
{
	protected $_entityName = "PiAppGedmoBundle:Ads";

	/**
     * Enabled Ads entities.
     *
     * @Route("/admin/gedmo/ads/enabled", name="admin_gedmo_ads_enabledentity_ajax")
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
     * Disable Ads entities.
     * 
     * @Route("/admin/gedmo/ads/disable", name="admin_gedmo_ads_disablentity_ajax")
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
     * Change the position of a Ads entity.
     *
     * @Route("/admin/gedmo/ads/position", name="admin_gedmo_ads_position_ajax")
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
     * Delete a Ads entity.
     *
     * @Route("/admin/gedmo/ads/delete", name="admin_gedmo_ads_deletentity_ajax")
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
     * Archive an Ads entity.
     *
     * @Route("/admin/gedmo/ads/archive", name="admin_gedmo_ads_archiveentity_ajax")
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
     * Lists all Ads entities.
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
        
    	if($NoLayout && $category && !empty($category)){
    		//$entities 	= $em->getRepository("PiAppGedmoBundle:Ads")->getAllEnableByCatAndByPosition($locale, $category, 'object');
    		$query		= $em->getRepository("PiAppGedmoBundle:Ads")->getAllByCategory($category, null, '', 'ASC', false)->getQuery();
    		$entities   = $em->getRepository("PiAppGedmoBundle:Ads")->findTranslationsByQuery($locale, $query, 'object', false);
    	}else
    		$entities	= $em->getRepository("PiAppGedmoBundle:Ads")->findAllByEntity($locale, 'object');    	

        return $this->render("PiAppGedmoBundle:Ads:$template", array(
            'entities'	=> $entities,
            'NoLayout'	=> $NoLayout,
            'category'	=> $category,
        ));
    }

    /**
     * Finds and displays a Ads entity.
     *
     * @Secure(roles="IS_AUTHENTICATED_ANONYMOUSLY")
	 * @return \Symfony\Component\HttpFoundation\Response
     *
	 * @access	public
	 * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>    
     */
    public function showAction($id)
    {
        $em 		= $this->getDoctrine()->getEntityManager();
        $locale		= $this->container->get('session')->getLocale();
        $entity 	= $em->getRepository("PiAppGedmoBundle:Ads")->findOneByEntity($locale, $id, 'object');
        
        $category   = $this->container->get('request')->query->get('category');
        $NoLayout   = $this->container->get('request')->query->get('NoLayout');
        if(!$NoLayout) 	$template = "show.html.twig"; else $template = "show.html.twig";        

        if (!$entity) {
            throw ControllerException::NotFoundException('Ads');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render("PiAppGedmoBundle:Ads:$template", array(
            'entity'      => $entity,
            'NoLayout'	  => $NoLayout,
            'category'	  => $category,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to create a new Ads entity.
     *
     * @Secure(roles="ROLE_USER")
	 * @return \Symfony\Component\HttpFoundation\Response
     *
	 * @access	public
	 * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>    
     */
    public function newAction()
    {
    	$em 		= $this->getDoctrine()->getEntityManager();
    	$entity 	= new Ads();
        $form   	= $this->createForm(new AdsType($em, $this->container), $entity, array('show_legend' => false));
        
        $category   = $this->container->get('request')->query->get('category');
        $NoLayout   = $this->container->get('request')->query->get('NoLayout');
        if(!$NoLayout)	$template = "new.html.twig";  else 	$template = "new.html.twig";   
        
        $entity_cat = $em->getRepository("PiAppGedmoBundle:Category")->find($category);
        if(($entity_cat instanceof \PiApp\GedmoBundle\Entity\Category) && method_exists($entity, 'setCategory'))
        	$entity->setCategory($entity_cat);     
        elseif(!empty($category) && method_exists($entity, 'setCategory'))
        	$entity->setCategory($category); 

        return $this->render("PiAppGedmoBundle:Ads:$template", array(
            'entity' 	=> $entity,
            'form'   	=> $form->createView(),
            'NoLayout'  => $NoLayout,
            'category'	=> $category,
        ));
    }

    /**
     * Creates a new Ads entity.
     *
     * @Secure(roles="ROLE_USER")
     * @return \Symfony\Component\HttpFoundation\Response
     *
	 * @access	public
	 * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>     
     */
    public function createAction()
    {
        $em 		= $this->getDoctrine()->getEntityManager();
        $locale		= $this->container->get('session')->getLocale();
        
        $category   = $this->container->get('request')->query->get('category');
        $NoLayout   = $this->container->get('request')->query->get('NoLayout');
        if(!$NoLayout)	$template = "new.html.twig";  else 	$template = "new.html.twig";        
    
        $entity 	= new Ads();
        $request 	= $this->getRequest();
        $form    	= $this->createForm(new AdsType($em, $this->container), $entity, array('show_legend' => false));
        $form->bindRequest($request);

        if ($form->isValid()) {
            $entity->setTranslatableLocale($locale);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_gedmo_ads_show', array('id' => $entity->getId(), 'NoLayout' => $NoLayout, 'category' => $category)));
                        
        }

        return $this->render("PiAppGedmoBundle:Ads:$template", array(
            'entity' 	=> $entity,
            'form'   	=> $form->createView(),
            'NoLayout'  => $NoLayout,
            'category'	=> $category,
        ));
    }

    /**
     * Displays a form to edit an existing Ads entity.
     *
     * @Secure(roles="ROLE_USER")
	 * @return \Symfony\Component\HttpFoundation\Response
     *
	 * @access	public
	 * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>    
     */
    public function editAction($id)
    {
        $em 		= $this->getDoctrine()->getEntityManager();
    	$locale		= $this->container->get('session')->getLocale();
        $entity 	= $em->getRepository("PiAppGedmoBundle:Ads")->findOneByEntity($locale, $id, 'object');
        
        $category   = $this->container->get('request')->query->get('category');
        $NoLayout   = $this->container->get('request')->query->get('NoLayout');
        if(!$NoLayout)	$template = "edit.html.twig";  else	$template = "edit.html.twig";        

        if (!$entity) {
        	$entity = $em->getRepository("PiAppGedmoBundle:Ads")->find($id);
        	$entity->addTranslation(new AdsTranslation($locale));            
        }

        $editForm   = $this->createForm(new AdsType($em, $this->container), $entity, array('show_legend' => false));
        $deleteForm = $this->createDeleteForm($id);

        return $this->render("PiAppGedmoBundle:Ads:$template", array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'NoLayout' 	  => $NoLayout,
            'category'	  => $category,
        ));
    }

    /**
     * Edits an existing Ads entity.
     *
     * @Secure(roles="ROLE_USER")
	 * @return \Symfony\Component\HttpFoundation\Response
     *
	 * @access	public
	 * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>   
     */
    public function updateAction($id)
    {
        $em 		= $this->getDoctrine()->getEntityManager();
    	$locale		= $this->container->get('session')->getLocale();
        $entity 	= $em->getRepository("PiAppGedmoBundle:Ads")->findOneByEntity($locale, $id, "object"); 
        
        $category   = $this->container->get('request')->query->get('category');
        $NoLayout   = $this->container->get('request')->query->get('NoLayout');
        if(!$NoLayout)	$template = "edit.html.twig";  else	$template = "edit.html.twig";        

        if (!$entity) {
        	$entity = $em->getRepository("PiAppGedmoBundle:Ads")->find($id);
        }

        $editForm   = $this->createForm(new AdsType($em, $this->container), $entity, array('show_legend' => false));
        $deleteForm = $this->createDeleteForm($id);

        $editForm->bindRequest($this->getRequest(), $entity);
        if ($editForm->isValid()) {
            $entity->setTranslatableLocale($locale);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_gedmo_ads_edit', array('id' => $id, 'NoLayout' => $NoLayout, 'category' => $category)));
        }

        return $this->render("PiAppGedmoBundle:Ads:$template", array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'NoLayout' 	  => $NoLayout,
            'category'	  => $category,
        ));
    }

    /**
     * Deletes a Ads entity.
     *
     * @Secure(roles="ROLE_USER")
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *     
	 * @access	public
	 * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>     
     */
    public function deleteAction($id)
    {
        $em 	 	= $this->getDoctrine()->getEntityManager();
	    $locale	 	= $this->container->get('session')->getLocale();
	    
	    $NoLayout   = $this->container->get('request')->query->get('NoLayout');	    
	    $category   = $this->container->get('request')->query->get('category');
    
        $form 	 	= $this->createDeleteForm($id);
        $request 	= $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
    	    $entity = $em->getRepository("PiAppGedmoBundle:Ads")->findOneByEntity($locale, $id, 'object');

            if (!$entity) {
                throw ControllerException::NotFoundException('Ads');
            }

        	try {
            	$em->remove($entity);
            	$em->flush();
            } catch (\Exception $e) {
            	$this->container->get('session')->setFlash('notice', 'pi.session.flash.right.undelete');
            }
        }

        return $this->redirect($this->generateUrl('admin_gedmo_ads', array('NoLayout' => $NoLayout, 'category' => $category)));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    /**
     * Template : Finds and displays a Ads entity.
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
    		
    	if(!empty($id)){
    		$entity	= $em->getRepository("PiAppGedmoBundle:Ads")->findOneByEntity($lang, $id, 'object', false);
    		$slug	= $entity->getSlug();
    	}else{
    		$slug	= $this->container->get('bootstrap.RouteTranslator.factory')->getMatchParamOfRoute('slug', $lang);
    		$entity	= $this->container->get('doctrine')->getEntityManager()->getRepository("PiAppGedmoBundle:Ads")->getEntityByField($lang, array('content_search' => array('slug' =>$slug)), 'object');
    	}    	
    	
    	if(method_exists($entity, "getTemplate") && $entity->getTemplate() != "")
    		$template = $entity->getTemplate();     	
    
    	return $this->render("PiAppGedmoBundle:Ads:$template", array(
    			'entity'	=> $entity,
    			'locale'	=> $lang,
    	));
    }

	/**
     * Template : Finds and displays a list of Ads entity.
     * 
     * @Cache(maxage="86400")
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @access	public
     * @author Etienne de Longeaux <etienne.delongeaux@gmail.com> 
     */
    public function _template_listAction($category = '', $MaxResults = null, $template = '_tmp_list.html.twig', $order = 'DESC', $lang = "")
    {
    	$em 		= $this->getDoctrine()->getEntityManager();
    	if(empty($lang))
    		$lang	= $this->container->get('session')->getLocale();
    		
    	$query		= $em->getRepository("PiAppGedmoBundle:Ads")->getAllByCategory($category, $MaxResults, $order)->getQuery();
        $entities   = $em->getRepository("PiAppGedmoBundle:Ads")->findTranslationsByQuery($lang, $query, 'object', false);                   

        return $this->render("PiAppGedmoBundle:Ads:$template", array(
            'ads' 	   => $entities,
            'cat'	   => ucfirst($category),
            'locale'   => $lang,
        ));
    }  

   /**
    * Template : Finds and displays an archive of Ads entity.
    *
    * @Cache(maxage="86400")
    * @return \Symfony\Component\HttpFoundation\Response
    *
    * @access	public
    * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>
    */
    public function _template_archiveAction($MaxResults = null, $template = '_tmp_archive.html.twig', $order = 'DESC', $lang = "")
    {
    	$em 		= $this->getDoctrine()->getEntityManager();
    
    	if(empty($lang))
    		$lang	= $this->container->get('session')->getLocale();
    	 
    	if(isset($_GET['page']) && !empty($_GET['page']))
    		$page 	= $_GET['page'];
    	else
    		$page 	= 1;
    	
    	if(empty($lang))
    		$lang	= $this->container->get('session')->getLocale();
    	 
    	if(isset($_GET['search']) && !empty($_GET['search']))
    		$search	=	trim($_GET['search']);
    	else
    		$search = "";
    	 
    	if(isset($_GET['filtre1']) && !empty($_GET['filtre1']))
    		$filtre1 =	$_GET['filtre1'];
    	else
    		$filtre1 = "";
    	 
    	if(isset($_GET['filtre2']) && !empty($_GET['filtre2']))
    		$filtre2 =	$_GET['filtre2'];
    	else
    		$filtre2 = ""; 
    	
    	if(isset($_GET['userID']) && !empty($_GET['userID']))
    		$userID =	$_GET['userID'];
    	else
    		$userID = "";    	

    	$paginator 			= $this->container->get('knp_paginator');
    
    	$query_pagination	= $em->getRepository("PiAppGedmoBundle:Ads")->getAllByCategory('', null, $order);
    	if(!empty($search)){
    		$query_pagination
    		->leftJoin('a.tags', 'tag')
    		->leftJoin('a.translations', 'trans');

    		$andModule = $query_pagination->expr()->andx();
    		$andModule->add($query_pagination->expr()->eq('LOWER(trans.locale)', "'{$lang}'"));
    		$andModule->add($query_pagination->expr()->like('LOWER(trans.content)', $query_pagination->expr()->literal('%'.strtolower($search).'%')));

    		$orModule  = $query_pagination->expr()->orx();
    		$orModule->add($andModule);
    		$orModule->add($query_pagination->expr()->like('LOWER(tag.name)', $query_pagination->expr()->literal('%'.strtolower($search).'%')));
    		$query_pagination->andWhere($orModule);
    	}
    	if(!empty($filtre1))
    		$query_pagination->andWhere($query_pagination->expr()->like('LOWER(a.typology)', $query_pagination->expr()->literal(strtolower($filtre1).'%')));
    	if(!empty($filtre2))
    		$query_pagination->andWhere($query_pagination->expr()->like('LOWER(a.status)', $query_pagination->expr()->literal(strtolower($filtre2).'%')));
    	if(!empty($userID)){
    		$query_pagination
    		->leftJoin('a.user', 'user')
    		->andWhere("user.id = :userID")
    		->setParameter('userID', $userID);
    	}
    	
    	$count			  = count($query_pagination->getQuery()->getResult());
    	$query_pagination = $query_pagination->getQuery();
    	
    	$pagination = $paginator->paginate(
    			$query_pagination,
    			$page,	/*page number*/
    			$MaxResults		/*limit per page*/
    	);
    	 
    	$query_pagination->setFirstResult(($page-1)*$MaxResults);
    	$query_pagination->setMaxResults($MaxResults);
    	$query_pagination	= $em->getRepository("PiAppGedmoBundle:Ads")->setTranslatableHints($query_pagination, $lang, false);
    	$entities			= $em->getRepository("PiAppGedmoBundle:Ads")->findTranslationsByQuery($lang, $query_pagination, 'object', false);
    	 
    	return $this->render("PiAppGedmoBundle:Ads:$template", array(
    			'entities'		=> $entities,
    			'pagination'	=> $pagination,
    			'locale'		=> $lang,
    			'lang'			=> $lang,
    			'search'   		=> $search,
    			'filtre1'   	=> $filtre1,
    			'filtre2'   	=> $filtre2,   
    			'total'			=> $count 			
    	));
    }      
    
    /**
     * Template : Form comment.
     *
     * @Cache(maxage="86400")
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @access	public
     * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>
     */
    public function _template_formAction($ads_id, $template = '_template_form_ads.html.twig', $lang = "")
    {
    	$em 		= $this->getDoctrine()->getEntityManager();
    
    	if(empty($lang))
    		$lang	= $this->container->get('session')->getLocale();
    
    	if ($this->isUsernamePasswordToken()) {
    		$user 		= $this->get('security.context')->getToken()->getUser();
    		$entity		= new \PiApp\GedmoBundle\Entity\Contact();
    		
    		$entity->setName($user->getUsername());
    		$entity->setNickname($user->getUsername());
    		$entity->setEmail($user->getEmail());
    		$entity->setDescriptif("Message *");
    		$entity->setAds($this->getAds($ads_id, $lang));
    		    		
    		$form   	= $this->createForm(new \PiApp\GedmoBundle\Form\AdsResponseType($em, $this->container), $entity, array('show_legend' => false));
    		 
    		return $this->render("PiAppGedmoBundle:Ads:$template", array(
    				'entity' 	=> $entity,
    				'form'   	=> $form->createView(),
    		));    		
    	}else{
   			$url		= $this->container->get('bootstrap.RouteTranslator.factory')->getRoute("page_lamelee_connexion", array('locale'=>$lang));
   			return new RedirectResponse($url);
    	}    	
    }
    
    /**
     * Template : Finds and displays a list of the last Lamelee\Article entity.
     *
     * @Route("/opportunite/{ads_id}", name="piapp_gedmo_ads_create", requirements={"_method"="POST", "ads_id" = "\d+"})
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @access	public
     * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>
     */
    public function _template_formValidationAction($ads_id, $lang = "")
    {
    	$em			= $this->getDoctrine()->getEntityManager();

    	if(empty($lang))
    		$lang   = $this->container->get('session')->getLocale();
    	
    	$entity		= new \PiApp\GedmoBundle\Entity\Contact();
    	$form		= $this->createForm(new \PiApp\GedmoBundle\Form\AdsResponseType($em, $this->container), $entity, array('show_legend' => false));
    	$request 	= $this->getRequest();
    	$form->bindRequest($request);

    	if ($form->isValid()) {
    		$entity->setTranslatableLocale($lang);
    		$ads = $this->getAds($ads_id, $lang);
    		$entity->setAds($ads);

    		//$query		= $em->getRepository("PiAppGedmoBundle:Category")->getAllByFields(array('type'=>'0', 'enabled'=>true), 1, '', 'ASC');
    		//$entity_cat =  current($em->getRepository("PiAppGedmoBundle:Category")->findTranslationsByQuery($lang, $query->getQuery(), "object", false));
    		$entity_cat		= $em->getRepository("PiAppGedmoBundle:Category")->find(19);
    		$entity->setCategory($entity_cat);
    		
    		$em->persist($entity);
    		$em->flush();
    		
    		$this->get('session')->setFlash('notice', 'comment.flash.posted');
    
    		//send mail
    		$templateFile = "PiAppGedmoBundle:Ads:email_ads.html.twig";
    		$templateContent = $this->get('twig')->loadTemplate($templateFile);
    		$subject = ($templateContent->hasBlock("subject")
    				           ? $templateContent->renderBlock("subject", array('ads'=>$ads, 'form'=> $request->get($form->getName(), array())))
    				           : "Default subject here");
    		$body = ($templateContent->hasBlock("body")
    				           ? $templateContent->renderBlock("body", array('ads'=>$ads, 'form'=> $request->get($form->getName(), array())))
    				           : "Default body here");
    		
			$list_files = $this->get("pi_app_admin.mailer_manager")->uploadAttached($_FILES);
    		$this->get("pi_app_admin.mailer_manager")->send('ads@lamelee.fr', $ads->getUser()->getEmail(), null, null, $form["Email"]->getData(), $subject, $body , $list_files);
			$this->get("pi_app_admin.mailer_manager")->deleteAttached($list_files);
    	}else{
    		$this->get('session')->setFlash('notice', 'comment.flash.noposted');
    	}
    	  
    	$new_url 	= $this->container->get('bootstrap.RouteTranslator.factory')->getRefererRoute($lang);
	    return new RedirectResponse($new_url);
    }
    
    protected function getAds($id, $lang)
    {
	    $em		= $this->getDoctrine()->getEntityManager();
	    $ads	= $em->getRepository("PiAppGedmoBundle:Ads")->findOneByEntity($lang, $id, 'object', false);
	    
		if(!$ads) {
	    	throw $this->createNotFoundException('Unable to find ads.');
	    }
	    
	    return $ads;
    }
   
}