<?php


namespace App\Controller;


use App\Repository\AgenteRepository;
use App\Repository\SituacionRevistaRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

class SituacionRevistaGlobalFilterAction
{
    
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var SituacionRevistaRepository
     */
    private $situacionRevistaRepository;
    
    
    public function __construct(SituacionRevistaRepository $situacionRevistaRepository,
                                LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->situacionRevistaRepository = $situacionRevistaRepository;
    }
    
    public function __invoke(Request $request)
    {
        $termino = $request->get('termino');
        
        $size =  $request->get('size');
        $size = isset($size) && $size ? $size : 20;
        
        $page = $request->get('page');
        $page = isset($page) && $page ? $page : 1;
        
        $order = $request->get('_order');
        $order = isset($order) && $order ? $order : array('id'=>'desc');
        
        $this->logger->info("Busqueda global de Situacion Revista ".$termino);
        
        $objects = $this->situacionRevistaRepository->findByTermino($termino,$page, $size, $order);
        $this->logger->info("Cantidad de Situacion Revista encontrados ".count($objects));
        return $objects;
    }
}