<?php


namespace App\Controller;


use App\Repository\SecretariaRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

class SecretariaGlobalFilterAction
{
    
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var SecretariaRepository
     */
    private $secretariaRepository;
    
    
    public function __construct(SecretariaRepository $secretariaRepository,
                                LoggerInterface $logger)
    {
        $this->logger = $logger;
    
        $this->secretariaRepository = $secretariaRepository;
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
        
        $this->logger->info("Busqueda global de Secretaria ".$termino);
        
        $configuraciones = $this->secretariaRepository->findByTermino($termino,$page, $size, $order);
        $this->logger->info("Cantidad de Secretaria encontradas ".count($configuraciones));
        return $configuraciones;
    }
}