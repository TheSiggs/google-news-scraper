<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GraphQl\QueryCollection;
use App\Repository\GoogleNewsRepository;
use App\Resolver\GoogleNewsCollectionResolver;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GoogleNewsRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    graphQlOperations: [
        new QueryCollection(
            resolver: GoogleNewsCollectionResolver::class, args: [
                'query' => ['type' => 'String!'],
                'api_key' => ['type' => 'String'],
                'results' => ['type' => 'Int']
            ], paginationEnabled: false, name: "query"
        ),
    ]
)]
class GoogleNews
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'Query', type: Types::STRING)]
    private ?string $query = null;

    #[ORM\Column(name: 'ApiUser', type: Types::TEXT)]
    private ?string $user = null;

    #[ORM\Column(name: 'Created', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Created = null;

    #[ORM\Column]
    private ?int $position = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups('read')]
    private ?string $link = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups('read')]
    private ?string $thumbnail = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups('read')]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups('read')]
    private ?string $snippet = null;

    #[ORM\Column(length: 255)]
    #[Groups('read')]
    private ?string $source = null;

    #[ORM\Column(length: 255)]
    #[Groups('read')]
    private ?string $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuery(): ?string
    {
        return $this->query;
    }

    public function setQuery(string $query): static
    {
        $this->query = $query;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->Created;
    }

    public function setCreated(\DateTimeInterface $Created): static
    {
        $this->Created = $Created;

        return $this;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(string $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): static
    {
        $this->link = $link;

        return $this;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(string $thumbnail): static
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSnippet(): ?string
    {
        return $this->snippet;
    }

    public function setSnippet(string $snippet): static
    {
        $this->snippet = $snippet;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): static
    {
        $this->source = $source;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): static
    {
        $this->date = $date;

        return $this;
    }
}
