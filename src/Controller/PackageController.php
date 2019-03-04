<?php

namespace App\Controller;

use App\Entity\Package;
use App\Entity\Purchase;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PackageController extends AbstractController
{
    /**
     * @Route("/package", name="package")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Package::class);
        $packages = $repo->findAll();
        return $this->render('package/index.html.twig', [
            'packages' => $packages,
        ]);
    }

    /**
     * @Route("/order/details/{id}", name="order_validation", options={"expose"=true})
     */
    public function details($id)
    {
        $repo = $this->getDoctrine()->getRepository(Package::class);
        $package = $repo->findOneBy([
            'id'=>$id
        ]);
        $package->setPrice($package->getPrice()/100);
        return $this->render('package/order.html.twig', [
            'package' => $package,
        ]);
    }

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
        $manager->flush();

        return $this->json(['resultat'=>'ok'], 200);
    }
}
