<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{

    /**
     * @Route("/blog", name="blog")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getManager();
        $articles = $repo->getRepository(Article::class)->findAll();

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/",name="home")
     */
    public function home()
    {
        return $this->render("blog/home.html.twig",[
            'title' => "This is a title",
            'age' => 31
        ]);
    }

    /**
     * @Route("/blog/new",name="blog_create")
     * @Route("blog/{id}/edit",name="blog_edit")
     */
    public function form(Article $article = null, Request $request, ObjectManager $manager){
        /*
        dump($request);

        if ($request->request->count()>0){

            $article = new Article();

            $article->setTitle($request->request->get('title'))
                    ->setContent($request->request->get('content'))
                    ->setImage($request->request->get('image'))
                    ->setCreateAt(new \DateTime());

            $manager->persist( $article );
            $manager->flush();

            return $this->redirectToRoute("show_blog",[
                'id' => $article->getId()
            ]);

        }
        */

        if (!$article){
            $article = new Article();

            //this is value for form
            $article->setTitle('This is title')
                ->setContent("This is contenu");
        }

        /*
        $form = $this->createFormBuilder($article)
                ->add('title',TextType::class,[
                    'attr' => [
                        'placeholder' => 'Titre'
                    ]
                ])
                ->add('content',TextareaType::class,[
                    'attr' => [
                        'placeholder' => 'Contenu'
                    ]
                ])
                ->add('image',TextType::class,[
                    'attr' => [
                        'placeholder' => 'Image'
                    ]
                ])
                ->getForm();
        */

        $form = $this->createForm(ArticleType::class,$article);

        $form->handleRequest($request);

        dump($article);

        if ($form->isSubmitted() && $form->isValid()){

            if (!$article->getId()){
                $article->setCreateAt(new \DateTime());
            }

            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute("show_blog",[
                'id' => $article->getId()
            ]);
        }

        return $this->render("blog/create.html.twig",[
            'formArticle' => $form->createView(),
            'editMode' => $article->getId() !== null
        ]);
    }

    /**
     * @Route("/show/{id}",name="show_blog")
     */
    public function show(ArticleRepository $article,$id)
    {
        $article = $article->find($id);
        return $this->render("blog/show.html.twig",[
            'article' => $article
        ]);
    }

}