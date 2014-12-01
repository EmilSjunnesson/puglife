<?php 

namespace Emsf14\Dicegame;

use \Emsf14\Dicegame\CDiceLogic;
use \Anax\Session\CSession;

class CDiceDisplay extends CDiceLogic {
  
  //Gets the pages querystring and passes it to the parent constructor
  public function __construct(array $queryGET, CSession $session) {
    parent::__construct($queryGET, $session);
  }
  
  // Returns html code to represent dice array
  private function GetRollsAsImageList() {
    $html = "<ul class='dice'>";
    if(count($this->dices) > 0) {
      foreach($this->dices as $val) {
        $html .= "<li class='dice-{$val}'></li>";
      }
    }
    $html .= "</ul>";
    return $html;        
  }
  
  // Prints out all html including gameboard and controls
  public function PrintHTML() {
    if(isset($this->queryGET['win'])) { 
      $html = "Grattis! Du lyckades samla ihop 100 poäng, du behövde bara {$this->ses->GetRounds()} omgångar<br><br>
      <a class='buttonLink' href='?restart'>Starta nytt spel</a>";      
    } else {
      $html = "<p>Tärningsspelet 100 är ett enkelt, men roligt, tärningsspel. Det gäller att samla ihop poäng för att komma först till 100. I varje omgång kastar en spelare tärning tills hon väljer att stanna och spara poängen eller tills det dyker upp en 1:a och hon förlorar alla poäng som samlats in i rundan.</p>
      <hr><br>
      {$this->Action()}<br><br>
      <div style='height: 40px;'>
      {$this->GetRollsAsImageList()}</div><br>
      Poäng i nuvarande omgång: {$this->sum}<br> 
      Sparade poäng: {$this->totalSum}<br>
      Antal omgångar: {$this->rounds}<br><br>
      <a class='as-button' href='?roll'>Kasta</a> <a class='as-button' href='?store'>Spara poäng</a> <a class='as-button' href='?restart'>Återställ spel</a>";
    }
    return $html;
  }
}
