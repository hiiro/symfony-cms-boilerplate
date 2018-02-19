<?php

namespace AdminBundle\Controller;

use CoreBundle\Entity\Administrator;
use AdminBundle\Form\Type\AdministratorType;
use CoreBundle\Traits\Paginator\PaginatorTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdministratorController extends Controller
{
    use PaginatorTrait;

    /**
     * @Route("/administrator/", name="admin_administrator_index")
     */
    public function defaultAction(Request $request)
    {
        $page = $request->get('page', 1);

        $builder = $this->getDoctrine()->getRepository('CoreBundle:Administrator')
            ->createQueryBuilder('e');

        $pagination = $this->paginate($builder, $page, 50, [
            'defaultSortFieldName' => ['e.createdAt', 'e.id'],
            'defaultSortDirection' => 'desc',
        ]);
        $pagination->setTemplate('@Admin/pagination.html.twig');

        return $this->render('@Admin/Administrator/default.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/administrator/show/{id}", name="admin_administrator_detail")
     */
    public function showAction(Request $request, Administrator $entry)
    {
        return $this->render('@Admin/Administrator/detail.html.twig', [
            'entry' => $entry,
        ]);
    }

    /**
     * @Route("/administrator/new", name="admin_administrator_new")
     */
    public function newAction(Request $request)
    {
        $entry = new Administrator();

        $form = $this->createForm(AdministratorType::class, $entry);

        if ($request->isMethod('POST')) {
            if ($form->handleRequest($request)->isValid()) {
                $manager = $this->getDoctrine()->getManager();

                if ($entry->getPlainPassword()) {
                    $encoder = $this->get('security.encoder_factory')->getEncoder($entry);
                    $entry->setPassword($encoder->encodePassword($entry->getPlainPassword(), $entry->getSalt()));
                }

                $manager->persist($entry);
                $manager->flush();

                $this->addFlash('success', '登録しました');

                return $this->redirectToRoute('admin_administrator_index');
            }
        }

        // replace this example code with whatever you need
        return $this->render('@Admin/Administrator/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/administrator/edit/{id}", name="admin_administrator_edit")
     * @param Administrator $entry
     */
    public function editAction(Request $request, Administrator $entry)
    {
        $form = $this->createForm(AdministratorType::class, $entry);

        if ($request->isMethod('POST')) {
            if ($form->handleRequest($request)->isValid()) {
                $manager = $this->getDoctrine()->getManager();

                if ($entry->getPlainPassword()) {
                    $encoder = $this->get('security.encoder_factory')->getEncoder($entry);
                    $entry->setPassword($encoder->encodePassword($entry->getPlainPassword(), $entry->getSalt()));
                }

                $manager->persist($entry);
                $manager->flush();

                $this->addFlash('success', '更新しました');

                return $this->redirectToRoute('admin_administrator_index');
            }
        }

        // replace this example code with whatever you need
        return $this->render('@Admin/Administrator/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/administrator/remove/{id}", name="admin_administrator_remove")
     */
    public function removeAction(Request $request, Administrator $entry)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($entry);
        $manager->flush();

        $this->addFlash('success', '削除しました');

        return $this->redirectToRoute('admin_administrator_index');
    }
}
