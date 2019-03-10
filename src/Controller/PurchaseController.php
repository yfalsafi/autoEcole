<?php

namespace App\Controller;

use App\Entity\Package;
use App\Entity\Purchase;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseController extends AbstractController
{

    /**
     * @param $id
     * @Route("/candidate/purchase/{id}",name="candidate_purchase", options={"expose"=true})
     * @return JsonResponse
     */
    public function UpdateStatus(ObjectManager $manager, Request $request, $id)
    {
        $repo = $this->getDoctrine()->getRepository(Package::class);
        $package = $repo->findOneBy([
            'id'=>$id
        ]);

        $purchase = new Purchase();
        $purchase->setBuyAt(new \DateTime())
            ->setPackage($package)
            ->setUser($this->getUser());
        if(!$package->getIsPackage())
        {
            $purchase->setQuantity($request->query->get('quantity'));
        }else
        {
            $purchase->setQuantity(1);
        }
        if(!$this->getUser()->getHoursLeft())
        {
            $this->getUser()->setHoursLeft($package->getNbHours());
        }
        else
        {
            $this->getUser()->setHoursLeft($this->getUser()->getHoursLeft() + $package->getNbHours());
        }
        $manager->persist($purchase);
        $manager->persist($this->getUser());
        $manager->flush();

        return $this->json(['resultat'=>'ok'], 200);
    }

    /**
     * @Route("/candidate/history", name="candidate_history")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Purchase::class);
        $purchases = $repo->findByUserJoinPackage($this->getUser());
        //dd($purchases);
        return $this->render('purchase/index.html.twig', [
            'purchases' => $purchases,
        ]);
    }
}
