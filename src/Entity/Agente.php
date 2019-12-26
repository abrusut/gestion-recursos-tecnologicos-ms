<?php


namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\AgenteGlobalFilterAction;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @ApiFilter(
 *     OrderFilter::class,
 *     properties={
 *              "id",
 *              "nombre",
 *              "apellido",
 *              "email",
 *              "numeroDocuento"
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
 *          "nombre":"partial",
 *          "apellido":"partial",
 *          "email":"partial",
 *          "numeroDocuento":"partial",
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
 *                      "path"="/agentes/globalFilter",
 *                      "controller"=AgenteGlobalFilterAction::class,
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
 * Agente
 * @ORM\Entity(repositoryClass="App\Repository\AgenteRepository")
 * @ORM\Table(name="agente")
 * @UniqueEntity(fields={"numeroDocumento"})
 * @ORM\HasLifecycleCallbacks()
 */
class Agente
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
     * @var string
     * @Groups({"get", "post","put"})
     * @ORM\Column(name="apellido", type="string", length=60,nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(min = 3)
     * @Assert\Length( max = 60)
     * @Assert\NotNull()
     */
    private $apellido;
    
    /**
     * @var \DateTime
     * @Groups({"get", "post","put"})
     *
     * @ORM\Column(name="fecha_nacimiento", type="date", nullable=true)
     * @Assert\NotNull()
     */
    private $fechaNacimiento;
    
    /**
     * @var string
     * @Groups({"get", "post","put"})
     * @ORM\Column(name="domicilio_calle", type="string", nullable=true,length=60)
     * @Assert\NotBlank()
     * @Assert\Length(min = 3)
     * @Assert\Length( max = 60)
     * @Assert\NotNull()
     */
    private $domicilioCalle;
    
    /**
     * @var integer
     * @Groups({"get", "post","put"})
     * @ORM\Column(name="domicilio_numero", type="integer",nullable=true)
     */
    private $domicilioNumero;
    
    /**
     * @var TipoDocumento
     * @Groups({"get", "post","put"})
     * @ORM\ManyToOne(targetEntity="TipoDocumento")
     */
    private $tipoDocumento;
    
    
    /**
     * @var integer
     * @Groups({"get", "post","put"})
     * @ORM\Column(name="numero_documento", type="integer", length=8)
     * @Assert\NotBlank()
     * @Assert\Length(min = 8)
     * @Assert\Length( max = 8)
     * @Assert\NotNull()
     */
    private $numeroDocumento;
    
    /**
     * @var String
     * @Groups({"get", "post","put"})
     * @ORM\Column(name="sexo", type="string", length=1, nullable=true)
     */
    private $sexo;
    
    /**
     * @var string
     * @Groups({"get", "post","put"})
     * @ORM\Column(name="telefono", type="string", length=25, nullable=true)
     * @Assert\Length( max = 25)
     */
    private $telefono;
    
    /**
     * @var string
     * @Groups({"get", "post","put"})
     * @ORM\Column(name="email", type="string", length=50, nullable=false)
     * @Assert\NotNull()
     * @Assert\Email()
     */
    private $email;
    
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
     * @return string
     */
    public function getApellido(): string
    {
        return $this->apellido;
    }
    
    /**
     * @param string $apellido
     */
    public function setApellido(string $apellido): void
    {
        $this->apellido = $apellido;
    }
    
    /**
     * @return \DateTime
     */
    public function getFechaNacimiento(): \DateTime
    {
        return $this->fechaNacimiento;
    }
    
    /**
     * @param \DateTime $fechaNacimiento
     */
    public function setFechaNacimiento(\DateTime $fechaNacimiento): void
    {
        $this->fechaNacimiento = $fechaNacimiento;
    }
    
    /**
     * @return string
     */
    public function getDomicilioCalle(): string
    {
        return $this->domicilioCalle;
    }
    
    /**
     * @param string $domicilioCalle
     */
    public function setDomicilioCalle(string $domicilioCalle): void
    {
        $this->domicilioCalle = $domicilioCalle;
    }
    
    /**
     * @return int
     */
    public function getDomicilioNumero(): int
    {
        return $this->domicilioNumero;
    }
    
    /**
     * @param int $domicilioNumero
     */
    public function setDomicilioNumero(int $domicilioNumero): void
    {
        $this->domicilioNumero = $domicilioNumero;
    }
    
    /**
     * @return TipoDocumento
     */
    public function getTipoDocumento(): TipoDocumento
    {
        return $this->tipoDocumento;
    }
    
    /**
     * @param TipoDocumento $tipoDocumento
     */
    public function setTipoDocumento(TipoDocumento $tipoDocumento): void
    {
        $this->tipoDocumento = $tipoDocumento;
    }
    
    /**
     * @return int
     */
    public function getNumeroDocumento(): int
    {
        return $this->numeroDocumento;
    }
    
    /**
     * @param int $numeroDocumento
     */
    public function setNumeroDocumento(int $numeroDocumento): void
    {
        $this->numeroDocumento = $numeroDocumento;
    }
    
    /**
     * @return String
     */
    public function getSexo(): String
    {
        return $this->sexo;
    }
    
    /**
     * @param String $sexo
     */
    public function setSexo(String $sexo): void
    {
        $this->sexo = $sexo;
    }
    
    /**
     * @return string
     */
    public function getTelefono(): string
    {
        return $this->telefono;
    }
    
    /**
     * @param string $telefono
     */
    public function setTelefono(string $telefono): void
    {
        $this->telefono = $telefono;
    }
    
    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
    
    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
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