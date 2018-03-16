<?php
/**
 * 
 * @Entity
 * @Table(name="urls")
 */
class Urls
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer", name="id")
     
     */
    protected $id;
    /**
     * @Column(type="string", name="url")
     */
    protected $url;

    /**
     * @Column(type="string", name="visited")
     */
    protected $visited;
    
    public function getId() {
        return $this->id;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function getVisited() {
        return $this->visited;
    }

    public function setVisited($visited) {
        $this->visited = $visited;
    }
}