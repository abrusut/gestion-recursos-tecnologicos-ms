<?php


namespace App\Entity;


use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\RecursoGlobalFilterAction;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @ApiFilter(
 *     OrderFilter::class,
 *     properties={
 *              "id",
 *              "nombre"
 *
 *     },
 *     arguments={"orderParameterName"="_order"}
 * )
 * @ApiFilter(
 *     RangeFilter::class,
 *     properties={
 *              "id"
 *     }
 * )
 * @ApiFilter(BooleanFilter::class, properties={"enabled"})
 * @ApiFilter(
 *     SearchFilter::class,
 *     properties={
 *           "id": "exact",
 *          "nombre":"partial"
 *
 *     }
 * )
 * @ApiResource(
 *     attributes={"order"={"id" : "DESC" },
 *                 "pagination_enabled"=true,
 *                 "pagination_client_enabled"=true,
 *                  "pagination_client_items_per_page"=true,
 *                  "maximum_items_per_page"=30
 *      },
 *      itemOperations={
 *              "get"={
 *                      "access_control"="is_granted('ROLE_ADMIN')",
 *                       "normalization_context"={
 *                            "groups" = { "get" }
 *                      }
 *               },
 *              "put"={
 *                      "access_control"="is_granted('ROLE_ADMIN')",
 *                      "denormalization_context"={
 *                            "groups" = { "put" }
 *                      },
 *                   "normalization_context"={
 *                            "groups" = { "get" }
 *                      }
 *              }
 *     },
 *      collectionOperations={
 *
 *              "get-global-search"={
 *                      "access_control"="is_granted('ROLE_ADMIN')",
 *                      "method"="GET",
 *                      "path"="/recursos/globalFilter",
 *                      "controller"=RecursoGlobalFilterAction::class,
 *                      "defaults"={"_api_receive"=false}
 *               },
 *              "get"={
 *                      "access_control"="is_granted('ROLE_ADMIN')",
 *                       "normalization_context"={
 *                            "groups" = { "get" }
 *                      }
 *               },
 *              "post" = {
 *                      "access_control"="is_granted('ROLE_ADMIN')",
 *                       "denormalization_context"={
 *                            "groups" = { "post" }
 *                      },
 *                      "normalization_context"={
 *                            "groups" = { "get" }
 *                      }
 *
 *
 *                  }
 *      }
 *
 * )
 *
 * @ORM\Entity(repositoryClass="App\Repository\RecursoRepository")
 * @ORM\Table(name="recurso")
 * @ORM\HasLifecycleCallbacks()
 */
class Recurso
{
    /**
     * @var int
     * @Groups({"get"})
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var string
     * @Groups({"get", "post","put"})
     * @ORM\Column(name="nombre", type="string", length=60,nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(min = 3)
     * @Assert\Length( max = 60)
     * @Assert\NotNull()
     */
    private $nombre;
    
    /**
     * @var \DateTime|null
     * @Groups({"get"})
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;
    
    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @Groups({"get"})
     */
    private $updatedAt;
    
    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_baja", type="datetime", nullable=true)
     * @Groups({"get", "post", "put"})
     */
    private $fechaBaja;
    
    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_desde", type="datetime", nullable=true)
     * @Groups({"get", "post", "put"})
     */
    private $fechaDesde;
    
    
    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_hasta", type="datetime", nullable=true)
     * @Groups({"get", "post", "put"})
     */
    private $fechaHasta;
    
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTime();
    }
    
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }
    
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    
    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    
    /**
     * @return string
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }
    
    /**
     * @param string $nombre
     */
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }
    
    /**
     * @return \DateTime|null
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }
    
    /**
     * @param \DateTime|null $createdAt
     */
    public function setCreatedAt(?\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
    
    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }
    
    /**
     * @param \DateTime|null $updatedAt
     */
    public function setUpdatedAt(?\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
    
    /**
     * @return \DateTime|null
     */
    public function getFechaBaja(): ?\DateTime
    {
        return $this->fechaBaja;
    }
    
    /**
     * @param \DateTime|null $fechaBaja
     */
    public function setFechaBaja(?\DateTime $fechaBaja): void
    {
        $this->fechaBaja = $fechaBaja;
    }
    
    
}