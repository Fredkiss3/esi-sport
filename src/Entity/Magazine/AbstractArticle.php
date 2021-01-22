<?php


namespace App\Entity\Magazine;


use Doctrine\ORM\Mapping as ORM;

abstract class AbstractArticle
{
    /**
     * @var \DateTimeInterface $publishedAt
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $publishedAt;

    /**
     * @var string $content
     *
     * @ORM\Column(type="text")
     */
    protected $content;

    /**
     * @return \DateTimeInterface
     */
    public function getPublishedAt(): \DateTimeInterface
    {
        return $this->publishedAt;
    }

    /**
     * @ORM\Column(type="boolean")
     */
    private $publish = false;


    /**
     * @param \DateTimeInterface $publishedAt
     * @return AbstractArticle
     */
    public function setPublishedAt(\DateTimeInterface $publishedAt): AbstractArticle
    {
        $this->publishedAt = $publishedAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return AbstractArticle
     */
    public function setContent(string $content): AbstractArticle
    {
        $this->content = $content;
        return $this;
    }


    public function getPublish(): ?bool
    {
        return $this->publish;
    }

    public function setPublish(bool $publish): self
    {
        $this->publish = $publish;
        $this->publishedAt = $publish ? new \DateTime : null;

        return $this;
    }

}