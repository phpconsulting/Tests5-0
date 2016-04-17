<?php
class VPeintres
{
  private $vhtml;
  
  public function __construct()
  {
    $this->vhtml = new VHtml();

  } // __construct()
  
  public function __destruct(){}
  
  public function showPeintres()
  {
    $this->showTable();
 
  } // showPeintres()

  public function showAdminPeintres()
  {
      echo '<div id="content1">';
      $this->showForm();
      echo '</div><!-- id="content1" -->';
  
      echo '<div id="content2">';
      $this->showTable();
      echo '</div><!-- id="content2" -->';

  } // showAdminPeintres()
  
  private function showForm()
  {
    $this->vhtml->showHtml('../Html/form_peintres.html');

  } // showForm()

  private function showTable()
  {
    $this->vhtml->showHtml('../Html/table_peintres.html.php');

  } // showTable()
  
} // VPeintres
?>