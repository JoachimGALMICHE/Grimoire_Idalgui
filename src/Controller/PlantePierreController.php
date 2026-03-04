<?php
namespace App\Controller;

use App\Entity\PlantePierre;
use App\Repository\PlantePierreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/plantes-pierres', name: 'pp_')]
class PlantePierreController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(PlantePierreRepository $repo, Request $request): Response
    {
        $user = $this->getUser();
        $voie = in_array('ROLE_SOLAIRE', $user->getRoles()) ? 'solaire' : 'lunaire';
        $onglet = $request->query->get('onglet', 'plante');
        $search = $request->query->get('q', '');

        $items = $search
            ? $repo->findByProprietaireCategorieAndSearch($user, $onglet, $search)
            : $repo->findByProprietaireAndCategorie($user, $onglet);

        return $this->render('plantes_pierres/' . $voie . '.html.twig', [
            'items' => $items,
            'voie' => $voie,
            'onglet' => $onglet,
            'search' => $search,
        ]);
    }

    #[Route('/nouvelle/{categorie}', name: 'new')]
    public function new(string $categorie, Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $voie = in_array('ROLE_SOLAIRE', $user->getRoles()) ? 'solaire' : 'lunaire';

        $item = new PlantePierre();
        $item->setVoie($voie);
        $item->setProprietaire($user);
        $item->setCategorie($categorie);

        if ($request->isMethod('POST')) {
            $item->setNom($request->request->get('nom', ''));
            $item->setOrigine($request->request->get('origine'));
            $item->setDescription($request->request->get('description'));
            $item->setProprietesMagiques($request->request->get('proprietes_magiques'));
            $item->setProprietesMedicinales($request->request->get('proprietes_medicinales'));
            $item->setCorrespondances($request->request->get('correspondances'));
            $item->setDanger($request->request->get('danger'));
            $item->setUtilisationRituel($request->request->get('utilisation_rituel'));

            $em->persist($item);
            $em->flush();

            return $this->redirectToRoute('pp_index', ['onglet' => $categorie]);
        }

        return $this->render('plantes_pierres/fiche_' . $voie . '.html.twig', [
            'item' => $item,
            'voie' => $voie,
            'mode' => 'new',
            'categorie' => $categorie,
        ]);
    }

    #[Route('/{id}/voir', name: 'show')]
    public function show(PlantePierre $item): Response
    {
        $this->denyAccessUnlessGranted('view', $item);
        return $this->render('plantes_pierres/fiche_' . $item->getVoie() . '.html.twig', [
            'item' => $item,
            'voie' => $item->getVoie(),
            'mode' => 'show',
            'categorie' => $item->getCategorie(),
        ]);
    }

    #[Route('/{id}/modifier', name: 'edit')]
    public function edit(PlantePierre $item, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('edit', $item);

        if ($request->isMethod('POST')) {
            $item->setNom($request->request->get('nom', ''));
            $item->setOrigine($request->request->get('origine'));
            $item->setDescription($request->request->get('description'));
            $item->setProprietesMagiques($request->request->get('proprietes_magiques'));
            $item->setProprietesMedicinales($request->request->get('proprietes_medicinales'));
            $item->setCorrespondances($request->request->get('correspondances'));
            $item->setDanger($request->request->get('danger'));
            $item->setUtilisationRituel($request->request->get('utilisation_rituel'));

            $em->flush();
            return $this->redirectToRoute('pp_show', ['id' => $item->getId()]);
        }

        return $this->render('plantes_pierres/fiche_' . $item->getVoie() . '.html.twig', [
            'item' => $item,
            'voie' => $item->getVoie(),
            'mode' => 'edit',
            'categorie' => $item->getCategorie(),
        ]);
    }

    #[Route('/{id}/supprimer', name: 'delete', methods: ['POST'])]
    public function delete(PlantePierre $item, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('edit', $item);
        $onglet = $item->getCategorie();
        $em->remove($item);
        $em->flush();
        return $this->redirectToRoute('pp_index', ['onglet' => $onglet]);
    }
}
