<?php


namespace App\Controller;


use App\Repository\AgenteRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

class AgenteGlobalFilterAction
{
    
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var AgenteRepository
     */
    private $agenteRepository;
    
    
    public function __construct(AgenteRepository $agenteRepository,
                                LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->agenteRepository = $agenteRepository;
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
        
        $this->logger->info("Busqueda global de Agentes ".$termino);
        
        $objects = $this->agenteRepository->findByTermino($termino,$page, $size, $order);
        $this->logger->info("Cantidad de Agentes encontrados ".count($objects));
        return $objects;
    }
}