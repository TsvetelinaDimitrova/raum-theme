<?php
  get_header();
?>
<div class="single-post">
  <div class="media">
    <img class="single-raumbild" src="<?php the_post_thumbnail_url('thumbnail'); ?>" alt="image">
  </div>

  <div class="container-raum">
    <?php
      if (have_posts()){
        while ( have_posts() ) {
          the_post(); ?>
          <h3><?php the_title() ?></h3>
          <div class="description">
            <?php the_content(); ?>
          </div>
      <?php
        }
      }
    ?>
  </div>
</div>
<div id="postID" style="display: none">
  <?php $post_id = get_the_ID();
        echo $post_id;
  ?>
</div>
<div class='calendar-container'>
  <div class="site-header autocomplete">
    <div class="input-wrapper">
      <input type="text" placeholder="Search" class="search-field">
        <span class="close">Cancel</span>
      <div class="focus-background"></div>
    </div>
     <div class="dialog"></div>
  </div>


  <div id='calendar'></div>

  <div id="calendar-popup">

    <form id="event-form">
       <div class='calander_popip_title'><i class="fa fa-calendar" aria-hidden="true"></i>
  Add Event</div>
      <ul>
        <li>
          <label for="event-start"><i class="fa fa-bell-o" aria-hidden="true"></i>

  From</label>
          <input id="event-start"  class='form-control' type="datetime-local" name="start"/>
        </li>
        <li>
          <label for="event-end"><i class="fa fa-bell-slash" aria-hidden="true"></i>

  To</label>
          <input id="event-end"  class='form-control' type="datetime-local" name="end"/>
        </li>
        <li>
          <label for="event-title"><i class="fa fa-calendar-minus-o" aria-hidden="true"></i>
  Event Name</label>
          <input id="event-title"  class='form-control' type="text" name="title"/>
        </li>
        <li>
          <label for="event-location"><i class="fa fa-map-marker" aria-hidden="true"></i>
  Location</label>
          <input id="event-location"   class='form-control' type="text" name="location"/>
        </li>
        <li>
          <label for="event-details"><i class="fa fa-info-circle" aria-hidden="true"></i>
  Description</label>
          <textarea id="event-details"  class='form-control' name="details"></textarea>
        </li>
        <div class="button">
          <input type="submit"  class='form-control submit_btn'/>
        </div>
      </ul>
    </form>

    <div id="event">
      <header></header>
      <ul>
      <li class="start-time">
        <p>
    Start at</p>
          <time></time>
        </li>
         <li class="end-time">
        <p>
   End</p>
          <time></time>
        </li>
        <li>
          <p>
            <i class="fa fa-map-marker" aria-hidden="true"></i>Location</p>
  <p class="location"></p>
        </li>
        <li>
          <p><i class="fa fa-info" aria-hidden="true"></i>
  Details:</p>
          <p class="details"></p>
        </li>
      </ul>

    </div>

    <div class="prong">
      <div class="bottom-prong-dk"></div>
      <div class="bottom-prong-lt"></div>
    </div>
  </div>


  <div class='modle' id='simplemodal'>
    <div class='modle-continer'>
        <form id="edit-form">

      <div class='modal-header'>
          <span class='close-btn' id='close-btnid'>&times</span>
        <h2>Edit Event</h2>
      </div>
     <div class='modal-body'>

       <lable for='eventname'>Event Name</lable>
       <input type='text' name='eventname' id='eventname' class='form-control'>
       <lable for='location'>Location</lable>
       <input type='text' name='location' id='location' class='form-control'>

       <label for="event-start">From</label><input id="eventstart" type="datetime-local" name="start" class='form-control'/>

       <label for="event-end">To</label>
          <input id="eventend" type="datetime-local" name="end" class='form-control'/>
        <label for="event-details">Details</label>
       <textarea id="eventdetails" type='text' name="details"  class='form-control'></textarea>

      </div>
      <div class='modal-footer'>
        <button type='submit' class='btn btn-info'>save</button>
        <button class='btn btn-dafault'>cancel</button>

      </div>
      </form>
    </div>

  </div>

  <div id='search_result'>result</div>
  <button class='btn btn-primary'>Add Events</button>
</div>

<?php
  get_footer();
?>
