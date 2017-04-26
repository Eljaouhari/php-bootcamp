<?php
class Personnage
{
  private $_degats,
          $_id,
          $_nom,
          $_niveau,
          $_experience;
  
  const CEST_MOI = 1; // Constante renvoyée par la méthode `frapper` si on se frappe soi-même.
  const PERSONNAGE_TUE = 2; // Constante renvoyée par la méthode `frapper` si on a tué le personnage en le frappant.
  const PERSONNAGE_FRAPPE = 3; // Constante renvoyée par la méthode `frapper` si on a bien frappé le personnage.
  
  
  public function __construct(array $donnees)
  {
    $this->hydrate($donnees);
  }
  
  public function frapper(Personnage $perso)
  {
    if ($perso->id() == $this->_id)
    {
      return self::CEST_MOI;
    }
    
    // On indique au personnage qu'il doit recevoir des dégâts.
    // Puis on retourne la valeur renvoyée par la méthode : self::PERSONNAGE_TUE ou self::PERSONNAGE_FRAPPE
    return $perso->recevoirDegats();
  }
  
  public function hydrate(array $donnees)
  {
    foreach ($donnees as $key => $value)
    {
      $method = 'set'.ucfirst($key);
      
      if (method_exists($this, $method))
      {
        $this->$method($value);
      }
    }
  }
  
  public function recevoirDegats()
  {
    $this->_degats += 5;
    
    // Si on a 100 de dégâts ou plus, on dit que le personnage a été tué.
    if ($this->_degats >= 100)
    {
      return self::PERSONNAGE_TUE;
    }
    
    // Sinon, on se contente de dire que le personnage a bien été frappé.
    return self::PERSONNAGE_FRAPPE;
  }

  public function gagnerExperience()
  {
    // Si on vient de tuer un personnage on gagne de l'experience'
      $this->_experience /= 3;
      $this->passerNiveau();
  }

  public function passerNiveau()
  {
    // Si l'experience du joueur atteint 100 donc le personnage passe de niveau
    $experience = $this->experience(); 

    if($experience >= 100){
      $this->_experience -= 100;
      $this->_niveau++;
    }

  }
  
  
  // GETTERS //
  
  public function id()
  {
    return $this->_id;
  }
  
  public function nom()
  {
    return $this->_nom;
  }

  public function degats()
  {
    return $this->_degats;
  }

  public function niveau()
  {
    return $this->_niveau;
  }

  public function experience()
  {
    return $this->_experience;
  }
  
  
    
  public function setId($id)
  {
    $id = (int) $id;
    
    if ($id > 0)
    {
      $this->_id = $id;
    }
  }
  
  public function setNom($nom)
  {
    if (is_string($nom))
    {
      $this->_nom = $nom;
    }
  }

  public function setDegats($degats)
  {
    $degats = (int) $degats;
    
    if ($degats >= 0 && $degats <= 100)
    {
      $this->_degats = $degats;
    }
  }

  public function setNiveau($niveau)
  {
    $niveau = (int) $niveau;

    if($niveau > 0 && $niveau <= 100){
       $this->_niveau = $niveau;
    }
  }

  public function setExperience($experience)
  {
    $experience = (int) $experience;

    if($experience > 0 && $experience <= 100){
       $this->_experience = $experience;
    }
  }

}