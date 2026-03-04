<?php
namespace App\Controller;

use App\Entity\Creature;
use App\Repository\CreatureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/bestiaire', name: 'bestiaire_')]
class BestiaireController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CreatureRepository $repo, Request $request): Response
    {
        $user = $this->getUser();
        $voie = in_array('ROLE_SOLAIRE', $user->getRoles()) ? 'solaire' : 'lunaire';
        $search = $request->query->get('q', '');

        $creatures = $search
            ? $repo->findByProprietaireAndNom($user, $search)
            : $repo->findByProprietaire($user);

        return $this->render('bestiaire/' . $voie . '.html.twig', [
            'creatures' => $creatures,
            'voie' => $voie,
            'search' => $search,
        ]);
    }

    #[Route('/nouvelle', name: 'new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $voie = in_array('ROLE_SOLAIRE', $user->getRoles()) ? 'solaire' : 'lunaire';

        $creature = new Creature();
        $creature->setVoie($voie);
        $creature->setProprietaire($user);

        if ($request->isMethod('POST')) {
            $creature->setNom($request->request->get('nom', ''));
            $creature->setType($request->request->get('type'));
            $creature->setOrigine($request->request->get('origine'));
            $creature->setDescription($request->request->get('description'));
            $creature->setPouvoirs($request->request->get('pouvoirs'));
            $creature->setDanger($request->request->get('danger'));
            $creature->setAffinites($request->request->get('affinites'));

            $em->persist($creature);
            $em->flush();

            return $this->redirectToRoute('bestiaire_index');
        }

        return $this->render('bestiaire/fiche_' . $voie . '.html.twig', [
            'creature' => $creature,
            'voie' => $voie,
            'mode' => 'new',
        ]);
    }

    #[Route('/{id}/voir', name: 'show')]
    public function show(Creature $creature): Response
    {
        $this->denyAccessUnlessGranted('view', $creature);
        $voie = $creature->getVoie();

        return $this->render('bestiaire/fiche_' . $voie . '.html.twig', [
            'creature' => $creature,
            'voie' => $voie,
            'mode' => 'show',
        ]);
    }

    #[Route('/{id}/modifier', name: 'edit')]
    public function edit(Creature $creature, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('edit', $creature);
        $voie = $creature->getVoie();

        if ($request->isMethod('POST')) {
            $creature->setNom($request->request->get('nom', ''));
            $creature->setType($request->request->get('type'));
            $creature->setOrigine($request->request->get('origine'));
            $creature->setDescription($request->request->get('description'));
            $creature->setPouvoirs($request->request->get('pouvoirs'));
            $creature->setDanger($request->request->get('danger'));
            $creature->setAffinites($request->request->get('affinites'));

            $em->flush();
            return $this->redirectToRoute('bestiaire_show', ['id' => $creature->getId()]);
        }

        return $this->render('bestiaire/fiche_' . $voie . '.html.twig', [
            'creature' => $creature,
            'voie' => $voie,
            'mode' => 'edit',
        ]);
    }

    #[Route('/{id}/supprimer', name: 'delete', methods: ['POST'])]
    public function delete(Creature $creature, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('edit', $creature);
        $em->remove($creature);
        $em->flush();
        return $this->redirectToRoute('bestiaire_index');
    }
}
