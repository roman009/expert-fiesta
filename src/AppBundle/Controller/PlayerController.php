<?php

namespace AppBundle\Controller;

use AppBundle\Application\Services\EpisodeSearchService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;

class PlayerController extends Controller
{
    /**
     * @Route("/", name="home", methods={"GET"})
     * @param Request $request
     * @param TranslatorInterface $translator
     * @param RouterInterface $router
     * @return Response
     */
    public function indexAction(Request $request, TranslatorInterface $translator, RouterInterface $router): Response
    {
        $searchForm = $this->createFormBuilder(null, ['method' => Request::METHOD_GET, 'action' => null])
            ->add('query', SearchType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => $translator->trans('Begin typing to search for a programme'),
                    'data-endpoint' => $router->generate('search')
                ],
            ])
            ->getForm();

        return $this->render('player/index.html.twig', ['search_form' => $searchForm->createView()]);
    }

    /**
     * @Route("/search", name="search", methods={"GET"})
     * @param Request $request
     * @param EpisodeSearchService $episodeSearchService
     * @return JsonResponse
     */
    public function searchAction(Request $request, EpisodeSearchService $episodeSearchService): JsonResponse
    {
        return $episodeSearchService->handle($request);
    }
}
