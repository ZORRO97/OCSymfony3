<?php

namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use OC\PlatformBundle\Entity\Advert;

class AdvertController extends Controller
{
    public function indexAction($page)
    {
    	if ($page < 1){
    		throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
    	}


    	// ici récupérer la liste des annonces
    	 // Notre liste d'annonce en dur
    $listAdverts = array(
      array(
        'title'   => 'Recherche développpeur Symfony',
        'id'      => 1,
        'author'  => 'Alexandre',
        'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
        'date'    => new \Datetime()),
      array(
        'title'   => 'Mission de webmaster',
        'id'      => 2,
        'author'  => 'Hugo',
        'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
        'date'    => new \Datetime()),
      array(
        'title'   => 'Offre de stage webdesigner',
        'id'      => 3,
        'author'  => 'Mathieu',
        'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
        'date'    => new \Datetime())
    );

         return $this->render('@OCPlatform/Advert/index.html.twig',array(
         		'listAdverts' => $listAdverts
         	));

   

    }

    public function viewAction($id){
    	// récupérer l'annonce pour $id
    	$advert = array(
      'title'   => 'Recherche développeur Symfony2',
      'id'      => $id,
      'author'  => 'Alexandre',
      'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
      'date'    => new \Datetime()
    );

    	
    	return $this->render('@OCPlatform/Advert/view.html.twig',
    			array(
    					'advert' => $advert
    				)
    		);
    }

    public function addAction(Request $request){
    	$advert = new Advert();
    	$advert->setTitle('Recherche développeur Symfony');
    	$advert->setAuthor('Alexandre');
    	$advert->setContent('Nous recherchons un développeur Symfony mouton à 5 pattes');
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($advert);
    	$em->flush();
    	if ($request->isMethod("POST")){
    		$session = $request->getSession();
    		$session->getFlashBag()->add('info','Annonce bien enregistrée');
    		return $this->redirectToRoute('oc_platform_view',array('id'=>5));
    	}

    	// service Antispam en test
    	/*$antispam = $this->container->get('oc_platform.antispam');
    	$text = "Bonne fête des morts Mesdames !";
    	die(var_dump(strlen($text)));
    	if ($antispam->isSpam($text)){
    		throw new \Exception('Votre message a été détecté comme spam !'); 
    	}
    	*/
    	return $this->redirectToRoute('oc_platform_view',array('id' => $advert->getId()));
    	
    	
    }

    public function editAction($id,Request $request){
    	if ($request->isMethod("POST")){
    		$request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée');
    		return $this->redirectToRoute('oc_platform_view',array('id'=>5));
    	}
    	$advert = array(
      'title'   => 'Recherche développpeur Symfony',
      'id'      => $id,
      'author'  => 'Alexandre',
      'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
      'date'    => new \Datetime()
    );
    	return $this->render('@OCPlatform/Advert/edit.html.twig',array(
    			'advert' => $advert
    		));
    }

    public function deleteAction($id){
    	return $this->render('@OCPlatform/Advert/delete.html.twig');
    }

    public function menuAction(){
    	// On fixe en dur une liste ici, bien entendu par la suite
	    // on la récupérera depuis la BDD !
	    $listAdverts = array(
	      array('id' => 2, 'title' => 'Recherche développeur Symfony'),
	      array('id' => 5, 'title' => 'Mission de webmaster'),
	      array('id' => 9, 'title' => 'Offre de stage webdesigner')
	    );

	    return $this->render('@OCPlatform/Advert/menu.html.twig', array(
	      // Tout l'intérêt est ici : le contrôleur passe
	      // les variables nécessaires au template !
	      'listAdverts' => $listAdverts
	    ));
    }

    public function viewSlugAction($slug,$year,$format){
    	return new Response("On pourrait afficher l'annonce correspondant au slug '".$slug."', créée en ".$year." et au format ".$format);
    }

    public function ajoutAction(){
    	$advert = new Advert();
    	$advert->setTitle('Recherche développeur Symfony');
    	$advert->setAuthor('Alexandre');
    	$advert->setContent('Nous recherchons un développeur Symfony mouton à 5 pattes');
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($advert);
    	$em->flush();
    	return $this->redirectToRoute('oc_platform_view',array('id' => $advert->getId()));
    }

}
