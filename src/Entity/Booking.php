<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BookingRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @ApiResource(
 * normalizationContext={
 *    "groups"={"bookings_read"}
 *   },
 * collectionOperations={"GET", "POST"},
 * itemOperations={"GET", "PUT", "DELETE"},
 * attributes={
 *    "pagination_enabled"=true,
 *    "pagination_items_per_page"=15,
 *    "pagination_client_enabled"=true,
 *    "pagination_client_items_per_page"=true,
 *    "pagination_items_per_page_parameter_name"="count",
 *   }
 * )
 */
class Booking
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"bookings_read","users_read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"bookings_read","users_read"})
     */
    private $booker;

    /**
     * @ORM\ManyToOne(targetEntity=Ad::class, inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"bookings_read","users_read"})
     */
    private $ad;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Date(message="Attention la date de début réservation doit être au bon format !")
     * @Groups({"bookings_read"})
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Date(message="Attention la date de fin de réservation doit être au bon format !")
     * @Assert\GreaterThan(propertyPath="startDate", message="La date de réservaion doit être plus éloigné que la date de retour.")
     * @Groups({"bookings_read"})
     */
    private $endDate;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"bookings_read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="float")
     * @Groups({"bookings_read"})
     */
    private $amount;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"bookings_read"})
     */
    private $comment;

    /**
     * Permet de récupérer un tableau des journées qui correspondent à ma réservation.
     *
     * @return array Un tableau d'objets DateTime représentant les jours de la réservation
     */
    public function getDays()
    {
        $result = range(
            $this->startDate->getTimestamp(),
            $this->endDate->getTimestamp(),
            24 * 60 * 60
        );

        $days = array_map(function ($dayTimestamp) {
            return new \DateTime(date('Y-m-d', $dayTimestamp));
        }, $result);

        return $days;
    }

    /**
     * Undocumented function.
     *
     * @return bool
     */
    public function isBookableDates()
    {
        //savoir si les dates impossible
        $notAvailableDays = $this->ad->getNotAvailableDays();
        //comparer les dates choisis avec dates impossible
        $bookingDays = $this->getDays();

        $formatDay = function ($day) {
            return $day->format('Y-m-d');
        };
        //tableau qui contient mes chaines de caractères de mes journées
        $days = array_map($formatDay, $bookingDays);
        $notAvailable = array_map($formatDay, $notAvailableDays);
        //comparaison des journées dispo et indispo
        foreach ($days as $day) {
            if (false !== array_search($day, $notAvailable)) {
                return false;
            }

            return true;
        }
    }

    /**
     * Callback appelé à chaque réservation.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function prePersist()
    {
        if (empty($this->createdAt)) {
            $this->createdAt = new \DateTime();
        }
        if (empty($this->amount)) {
            $this->amount = $this->ad->getPrice() * $this->getDuration();
        }
    }

    public function getDuration()
    {
        $diff = $this->endDate->diff($this->startDate);

        return $diff->days;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBooker(): ?User
    {
        return $this->booker;
    }

    public function setBooker(?User $booker): self
    {
        $this->booker = $booker;

        return $this;
    }

    public function getAd(): ?Ad
    {
        return $this->ad;
    }

    public function setAd(?Ad $ad): self
    {
        $this->ad = $ad;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }
}
