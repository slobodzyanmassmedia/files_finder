<?php

namespace Massmedia\FilesFinderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{
    /**
     * Show search form and results
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('files_finder_search'))
            ->add('search', 'text', array('label' => false))
            ->add('doSearch', 'submit')
            ->getForm();

        $founded = [];
        $form->submit($request);
        if ($form->isValid()) {
            $search = $form->getData()['search'];
            $finder = $this->get('massmedia.file_by_content');
            $userFiles = $this->get('kernel')->getRootDir() . '/../web/user_files';
            $founded = $finder->search($userFiles, $search);
        }

        return $this->render('FilesFinderBundle:Search:index.html.twig', array(
            'form' => $form->createView(),
            'founded' => $founded
        ));
    }
}
