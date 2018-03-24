<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Mutation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template
     */
    public function indexAction(Request $request)
    {
        $mutations = $this->getDoctrine()->getRepository(Mutation::class)->findBy([], ['datetime' => 'ASC']);
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
            'mutations' => $mutations,
            'total' => $total,
        ];
    }
}
