<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\AdminBookingType;
use App\Service\PaginationService;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBookingController extends AbstractController
{
    /**
     * @Route("/admin/bookings/{page<\d+>?1}", name="admin_booking_index")
     */
    public function index(BookingRepository $repo, $page,PaginationService $pagination): Response
    {
        $pagination->setEntityClass(Booking::class);
        return $this->render('admin/ad/index.html.twig', [
            'pagination' => $pagination
            ]);
    }


    /**
     * Permet d'éditer une réservation
     * @Route("/admin/bookings/{id}/edit", name="admin_booking_edit")
     * @return Response
     */
    public function edit(Booking $booking, Request $request, EntityManagerInterface $manager){
        
        $form = $this->createForm(AdminBookingType::class, $booking);
        
        if($form->isSubmitted() && $form->isValid()){
            
            $booking->setAmount(0);

            $manager->persist($booking);
            $manager->flush();
            
            
            $this->addFlash(
                'success',
                "La réservation n° {$booking->getId()} a bien été modifié !"
            );

        }
        return $this->render('admin/booking/edit.html.twig',[
            'form' => $form->createView(),
            'booking' => $booking
        ]);
    }

    /**
     * Permet de supprimer une réservation
     * @Route("/admin/bookings/{id}/delete", name="admin_booking_delete")
     * @param Booking $booking
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Booking $booking, EntityManagerInterface $manager){
        $manager->remove($booking);
        $manager->flush();

        $this->addFlash(
            'success',
            "Le commentaire a bien été supprimé !"
        );

        return $this->redirectToRoute(('admin_booking_index'));
    }

}
