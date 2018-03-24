<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Mutation;
use AppBundle\Form\Type\MutationFilterType;
use AppBundle\Model\MutationFilter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {
        $filter = new MutationFilter();
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
        return [
            'filterForm' => $filterForm->createView(),
            'mutations' => $mutations,
            'total' => $total,
        ];
    }
}