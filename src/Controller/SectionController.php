<?php

namespace App\Controller;

use App\Entity\Section;
use App\Form\SectionType;
use App\Repository\SectionRepository;
use App\Service\ImageUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/section", name="app_section_")
 *
 * @see \App\Tests\Controller\SectionControllerTest
 */
final class SectionController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(SectionRepository $sectionRepository): Response
    {
        return $this->render('section/index.html.twig', [
            'sections' => $sectionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request, ImageUploader $imageUploader): Response
    {
        $section = new Section();
        $form = $this->createForm(SectionType::class, $section);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();

            if (null !== $imageFile) {
                $imageFilename = $imageUploader->upload(
                    $imageFile,
                    $this->getParameter('uploads')['section_images']
                );

                if (null !== $imageFilename) {
                    $section->setImageFilename($imageFilename);
                } else {
                    $this->addFlash('warning', 'Image could not be uploaded !');
                }
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($section);
            $entityManager->flush();

            $this->addFlash('success', 'Section added !');

            return $this->redirectToRoute('app_section_index');
        }

        return $this->render('section/new.html.twig', [
            'section' => $section,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Section $section): Response
    {
        return $this->render('section/show.html.twig', [
            'section' => $section,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Section $section, ImageUploader $imageUploader): Response
    {
        $form = $this->createForm(SectionType::class, $section);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();

            if (null !== $imageFile) {
                $imageFilename = $imageUploader->upload(
                    $imageFile,
                    $this->getParameter('uploads')['section_images'],
                    $section->getImageFilename()
                );

                if (null !== $imageFilename) {
                    $section->setImageFilename($imageFilename);
                } else {
                    $this->addFlash('warning', 'Image could not be uploaded !');
                }
            }

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Section updated !');

            return $this->redirectToRoute('app_section_index');
        }

        return $this->render('section/edit.html.twig', [
            'section' => $section,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Section $section, ImageUploader $imageUploader): Response
    {
        if ($this->isCsrfTokenValid('delete'.$section->getId(), $request->request->get('_token'))) {
            if (null !== $section->getImageFilename()) {
                $imageUploader->remove(
                    $section->getImageFilename(),
                    $this->getParameter('uploads')['section_images']
                );
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($section);
            $entityManager->flush();

            $this->addFlash('success', 'Section deleted !');
        }

        return $this->redirectToRoute('app_section_index');
    }

    /**
     * @Route("/{id}/img/delete", name="delete_img", methods={"DELETE"})
     */
    public function deleteImage(Request $request, Section $section, ImageUploader $imageUploader): Response
    {
        if ($this->isCsrfTokenValid('delete_image'.$section->getId(), $request->request->get('_token'))) {
            if (null !== $section->getImageFilename()) {
                $imageUploader->remove(
                    $section->getImageFilename(),
                    $this->getParameter('uploads')['section_images']
                );

                $section->setImageFilename(null);
            }

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Image deleted !');
        }

        return $this->redirectToRoute('app_section_edit', [
            'id' => $section->getId(),
        ]);
    }
}
