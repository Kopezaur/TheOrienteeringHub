<?php 
namespace App\Controller;

use App\Entity\Post;
use App\Entity\PostImage;
use App\Entity\Person;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PostController extends Controller {

    /**
     * @Route("/post/index", name="indexPosts")
     */
    public function indexPosts(Request $request)
    {
        $user = $this->getUser();
        if($user->getRole()->getName() != "Admin"){
            return $this->redirectToRoute('access-denied');
        } else {
            $posts = $this->getDoctrine()->getRepository(Post::class)->findBy([], ['createdOn' => 'DESC']);
            
            return $this->render('post/index.html.twig', array(
                'posts' => $posts,
            ));
        }
    }
    
    /**
     * @Route("/post/add/{authorId}", name="addPost")
     */
    public function addPost(Request $request, $authorId)
    {
        $user = $this->getUser();
        if($user->getRole()->getName() != "Admin" && $user->getId() != $authorId){
            return $this->redirectToRoute('access-denied');
        } else {
            
            $post = new Post();
            
            $em = $this->getDoctrine()->getManager();
            $author = $em->getRepository(Person::class)->find($authorId);
            
            $form = $this->createFormBuilder($post)
            ->add('title', TextType::class, array(
                'label' => 'Title : ',
                'label_attr' => array('class' => 'mb-3 font-weight-normal'),
                'required' => true,
                'attr' => array('class' => 'form-control')))
                ->add('description', TextType::class, array(
                    'label' => 'Description : ',
                    'label_attr' => array('class' => 'mb-3 font-weight-normal'),
                    'required' => true,
                    'attr' => array('class' => 'form-control')))
                ->add('save', SubmitType::class, array(
                    'label' => 'Save',
                    'attr' => array('class' => 'btn btn-lg btn-primary btn-block')))
                    ->getForm();
                    
                    $form->handleRequest($request);
                    
                    if ($form->isSubmitted() && $form->isValid()) {
                        
                        $post = $form->getData();
                        
                        $post->setAuthor($author);
                        
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($post);
                        $em->flush();
                        
                        return $this->redirectToRoute('viewPost', array('id' => $post->getId()));
                    }
                    
                    return $this->render('post/form.html.twig', array(
                        'form' => $form->createView(),
                        'author' => $author,
                        'edit' => false,
                    ));
        }
    }
    
    /**
     * @Route("/post/edit/{id}", name="editPost")
     */
    public function editPost(Request $request, $id)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Post::class)->find($id);
        
        if($user->getRole()->getName() != "Admin" && $user->getId() != $post->getAuthor()->getId()){
            return $this->redirectToRoute('access-denied');
        } else {
            
            $form = $this->createFormBuilder($post)
            ->add('title', TextType::class, array(
                'label' => 'Title : ',
                'label_attr' => array('class' => 'mb-3 font-weight-normal'),
                'required' => true,
                'attr' => array('class' => 'form-control')))
                ->add('description', TextType::class, array(
                    'label' => 'Description : ',
                    'label_attr' => array('class' => 'mb-3 font-weight-normal'),
                    'required' => true,
                    'attr' => array('class' => 'form-control')))
                    ->add('save', SubmitType::class, array(
                        'label' => 'Save',
                        'attr' => array('class' => 'btn btn-lg btn-primary btn-block')))
                        ->getForm();
                        
                        $form->handleRequest($request);
                        
                        if ($form->isSubmitted() && $form->isValid()) {
                            
                            $post = $form->getData();
                            
                            $em = $this->getDoctrine()->getManager();
                            $em->persist($post);
                            $em->flush();
                            
                            return $this->redirectToRoute('viewPost', array('id' => $post->getId()));
                        }
                        
                        return $this->render('post/form.html.twig', array(
                            'form' => $form->createView(),
                            'edit' => true,
                        ));
        }
    }
    
    /**
     * @Route("/post/view/{id}", name="viewPost")
     */
    public function viewPost(Request $request, $id)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Post::class)->find($id);

        $postImages = [];
        // Retrieve the list of images for each post
        $qb = $em->createQueryBuilder();
        $qb->select('p')
            ->from('App\Entity\PostImage', 'p')
            ->where('p.post = ?1')
            ->setParameter(1, $id);
        $postImages = $qb->getQuery()->getResult();
        
        $postImage = new PostImage();
        
        $form = $this->createFormBuilder($postImage)
        ->add('imagename', FileType::class, array(
            'label' => false,
            'label_attr' => array('class' => 'mb-3 font-weight-normal'),
            'required' => true,
            'data_class' => null))
            ->add('save', SubmitType::class, array(
                'label' => 'Save',
                'attr' => array('class' => 'btn btn-primary', 'onclick' => 'form_submit()')))
                ->getForm();
            
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form['imagename']->getData();

            $fileName = $this->generateUniqueFileName() . '.' . $file->getClientOriginalExtension();

            // moves the file to the directory where images are stored
            $file->move($this->getParameter('images_directory'), $fileName);

            // updates the 'profile' property to store the image name
            // instead of its contents
            $postImage->setImagename($fileName);
            $postImage->setPost($post);

            $em = $this->getDoctrine()->getManager();
            $em->persist($postImage);
            $em->flush();

            return $this->redirectToRoute('viewPost', array(
                'id' => $id
            ));
        }

        return $this->render('post/view.html.twig', array(
            'post' => $post,
            'postImages' => $postImages,
            'form' => $form->createView()
        ));
    }
    
    /**
     * @Route("/post/delete/{id}", name="deletePost")
     */
    public function deletePost(Request $request, $id)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Post::class)->find($id);
        
        if($user->getRole()->getName() != "Admin" && $user->getId() != $post->getAuthor()->getId()){
            return $this->redirectToRoute('access-denied');
        } else {
            $authorId = $post->getAuthor()->getId();
            
            // Check if this post had images
            $qb = $em->createQueryBuilder();
            $qb->select('p')
            ->from('App\Entity\PostImage','p')
            ->where('p.post = ?1')
            ->setParameter(1, $id);
            $personImages = $qb->getQuery()->getResult();
            // If it has, we delete them all
            foreach($personImages as $image){
                $em->remove($image);
                $em->flush();
            }
            
            $em->remove($post);
            $em->flush();
            
            return $this->redirectToRoute('viewPerson', array('id' => $authorId));
        }
    }
    
    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}