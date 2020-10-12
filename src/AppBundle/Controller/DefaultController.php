<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Mutation;
use AppBundle\Form\Type\MutationFilterType;
use AppBundle\Model\Mutation\Filter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     *
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $filter = new Filter();
        $filterForm = $this->createForm(MutationFilterType::class, $filter, ['method' => 'get']);
        $filterForm->handleRequest($request);

        $mutations = $this->getDoctrine()->getRepository(Mutation::class)->findWithFilter($filter);

        $total = 0;

        /** @var Mutation $mutation */
        foreach ($mutations as $mutation) {
            if (Mutation::TYPE_DEBIT === $mutation->getType()) {
                $total += $mutation->getAmount();
            } else {
                $total -= $mutation->getAmount();
            }
        }

        // replace this example code with whatever you need
        return $this->render('@App/Default/index.html.twig', [
            'filterForm' => $filterForm->createView(),
            'mutations' => $mutations,
            'total' => $total,
        ]);
    }

    /**
     * @Route("/monthly", name="monthly")
     *
     * @param Request $request
     * @return Response
     */
    public function monthlyAction(Request $request)
    {
        $ownAccounts = ['NL78RABO1472296273', 'NL37INGB0008212053', 'NL48RABO0145123219', 'NL52NNBA2027725776'];

        $months = [];
        /** @var Mutation $mutation */
        foreach($this->getDoctrine()->getRepository(Mutation::class)->findAll() as $mutation) {
            if (in_array($mutation->getContraAccountNumber(), $ownAccounts)) {
                continue;
            }

            if (!isset($months[$mutation->getDate()->format('Ym')])) {
                $months[$mutation->getDate()->format('Ym')] = [
                    'categories' => [],
                    'amount' => 0,
                ];
            }

            $category = $mutation->getCategory() ? $mutation->getCategory()->getName() : 'Overig';
            if (!isset($months[$mutation->getDate()->format('Ym')]['categories'][$category])) {
                $months[$mutation->getDate()->format('Ym')]['categories'][$category] = [
                    'amount' => 0,
                    'mutations' => [],
                ];
            }

            $months[$mutation->getDate()->format('Ym')]['categories'][$category]['mutations'][] = $mutation;

            switch ($mutation->getType()) {
                case Mutation::TYPE_CREDIT:
                    $months[$mutation->getDate()->format('Ym')]['amount'] -= $mutation->getAmount();
                    $months[$mutation->getDate()->format('Ym')]['categories'][$category]['amount'] -= $mutation->getAmount();
                    break;
                case Mutation::TYPE_DEBIT:
                    $months[$mutation->getDate()->format('Ym')]['amount'] += $mutation->getAmount();
                    $months[$mutation->getDate()->format('Ym')]['categories'][$category]['amount'] += $mutation->getAmount();
                    break;
            }
        }

        krsort($months);

        return $this->render('@App/Default/monthly.html.twig', [
            'months' => $months,
        ]);
    }
}