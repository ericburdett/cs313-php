<!DOCTYPE html>
  <head>
    <title>"My Personal Homepage."</title>
    <meta charset="utf-8">
  </head>
  <script>
    function showJazz() {
      document.getElementById("jazzVideo").style.display = "block";
      document.getElementById("cardsVideo").style.display = "none";
      document.getElementById("cardsVid").pause();
    }

    function showCards() {
      document.getElementById("cardsVideo").style.display = "block";
      document.getElementById("jazzVideo").style.display = "none";
      document.getElementById("jazzVid").pause();
    }
  </script>

  <body>

  <?php
    require 'header.php'
  ?>

  <br />
  <div class="row">
    <div class="col-md-4">
      <figure>
        <a href="https://www.nba.com/jazz"><img id="jazz" class="img-responsive" src="utah_jazz_logo.png" alt="Jazz"></a>
        <figcaption>
          <a href="https://www.nba.com/jazz">Utah Jazz Team Site</a>
        </figcaption>
        <br />
        <h4>Location: Salt Lake City, Utah</h4>
        <h4>Established: 1974</h4>
        <h4>Championships: 0</h4>
        <br />
        <button type="button" class="btn btn-primary" onclick="showJazz()">I'm a Jazz Fan!</button>
        <br />
      </figure>
    </div> 
    <div class="col-md-4">
      <figure>
        <a href="https://www.mlb.com/cardinals"><img id="cards" class="img-responsive" src="st_louis_cardinals_logo.png" alt="Cardinals"></a>
        <figcaption>
          <a href="https://www.mlb.com/cardinals">St. Louis Cardinals Team Site</a>
        </figcaption>
        <br />
        <h4>Location: St. Louis, Missouri</h4>
        <h4>Established: 1882</h4>
        <h4>Championships: 11</h4>
        <br />
        <button type="button" class="btn btn-primary" onclick="showCards()">I'm a Cardinals Fan!</button>
        <br />
      </figure>
    </div>
    <div class="col-md-4">
      <figure>
        <a href="https://byucougars.com"><img id="cougs" class="img-responsive" src="byu_logo.png" alt="Cougars"></a>
        <figcaption>
          <a href="https://byucougars.com">BYU Cougars Team Site</a>
        </figcaption>
        <br />
        <h4>Location: Provo, Utah</h4>
        <h4>Established: 1875</h4>
        <h4>Championships(Football): 1</h4>
        <br />
        <button type="button" class="btn btn-primary" onclick="alert('That\'s unfortunate.\nYou may want to change your mind...')">I'm a Cougars Fan!</button>
        <br />
     </figure>
    </div>
  </div>

  <div id="jazzVideo">
    <video id="jazzVid" width="1000" height="700" controls>
      <source src="jazz.mp4" type="video/mp4">
      Your browswer does not support HTML5 video.
    </video>
  </div>

  <div id="cardsVideo">
    <video id="cardsVid" width="1000" height="700" controls>
      <source src="cards.mp4" type="video/mp4">
      Your browswer does not support HTML5 video.
    </video>
  </div>

  </body>

</html>