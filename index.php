<?php
date_default_timezone_set('UTC');
$GLOBALS['DEBUG'] = true;
if ( $GLOBALS['DEBUG'] ) {
  error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
} else {
  error_reporting(0);
}
function dbGo($host, $user, $pass, $db) {
  mysql_connect($host, $user, $pass);
  mysql_select_db($db);
  mysql_query("SET NAMES UTF8");
}
function dbGet($sql) {
  $rows = array();
  $result = mysql_query($sql);
  if (!$result) {
    if ( $GLOBALS['DEBUG'] ) {
      echo 'Query (' . $sql . ') produced error: ' . mysql_error() . "\n";
    }
    return $rows;
  }
  while ($row = mysql_fetch_assoc($result)) {
    if ( count($row) == 1 ) $rows[] = array_pop($row);
    else $rows[] = $row;
  }
  mysql_free_result($result);
  return $rows;
}
function dbExec($sql) {
  mysql_query($sql) or die("Database error" . ( $GLOBALS['DEBUG'] ? ": " . mysql_error() : "." ));
}
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
  $_POST['ts'] = date('U');
  $link = dbGo('localhost', 'devsurvey', 'devsurvey', 'devsurvey');
  $insert_statement = 'INSERT INTO devsurvey (';
  $fields = array(
    'ts','closing_important_1','closing_important_1_why','closing_important_2','closing_important_2_why','closing_important_3','closing_important_3_why','closing_interview','ghu','source','basics_develop_software','basics_develop_programming_tenure','basics_github_proglangs','basics_github_progtools','collab_projects','collab_projects_other_text','collab_team_smallest','collab_team_largest','up2date_up2date','up2date_up2date_other_text','up2date_answers','up2date_answers_other_text','up2date_learn','up2date_learn_other_text','rel_discover','rel_discover_other_text','rel_connect','rel_connect_other_text','rel_feedback','rel_feedback_other_text','profiles_publish','profiles_publish_other_text','profiles_watch','profiles_watch_other_text','profiles_display','profiles_display_other_text','profiles_assess','profiles_assess_other_text','collab_coord','collab_coord_other_text','mobile_use','mobile_use_other_text','challenges_overwhelm','challenges_privacy','challenges_distract','challenges_other','closing_results','closing_results_email','closing_age','closing_gender','closing_country','closing_comments'
  );
  foreach ($fields as $field) {
    $insert_statement .= $field;
    if ( $field !== end($fields) ) {
      $insert_statement .= ',';
    }
  }
  $insert_statement .= ') VALUES (';
  foreach ($fields as $field) {
    $insert_statement .= '"' . mysql_real_escape_string($_POST[$field]) . '"';
    if ( $field !== end($fields) ) {
      $insert_statement .= ',';
    }
  }
  $insert_statement .= ');';
  dbExec($insert_statement);
  header('Location: thank-you.html');
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>University of Victoria Developer Survey 2013</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/grid.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="container">

      <div class="jumbotron">
        <h1>University of Victoria Developer Survey:</h1>
        <h2 class="subtitle">How do you communicate and collaborate in 2013?</h2>
        <p>
          Hello!
        </p>
        <p>
          We’re researchers from the University of Victoria and we’re interested in how software developers communicate and collaborate.
        </p>
        <p>
          We'd be grateful if you could help us understand this better by filling the survey below. It should only take about 10 minutes of your time.
        </p>
        <p>
          This is a purely academic research project with no commercial interests. We will <em>openly publish</em> the results so everyone can benefit from them, but will <em>anonymize</em> everything before doing so. We will handle your response confidentially. If at some point during the survey you want to stop, you're free to do so without any negative consequences.
        </p>
        <p>
          Thanks a lot for participating!
        </p>
        <p>
          <a href="http://webhome.cs.uvic.ca/~mstorey">Margaret-Anne Storey</a>, <a href="http://leif.me">Leif Singer</a> and <a href="http://brendancleary.com">Brendan Cleary</a> from the <a href="https://www.uvic.ca">University of Victoria</a> in Canada.
        </p>
      </div>
      <form action="" method="POST">
      <h3>Basics</h3>
      <div class="question">
        <div class="question-title">
          <label for="ghu"><em>1. </em>What is your GitHub username?</label>
        </div>
        <div class="question-comment" id="ghu-note-delete">
          This will give us some context for your responses. Delete if you're uneasy about it.
        </div>
        <div class="question-comment" id="ghu-note-blank">
          This will give us some context for your responses. Leave blank if you're uneasy about it.
        </div>
        <div class="question-input">
          <input type="text" name="ghu" id="ghu">
        </div>
      </div>
      <div class="question">
        <div class="question-title">
          <em>2. </em>Do you develop software?
        </div>
        <div class="question-comment">
        </div>
        <div class="question-input">
          <label style="display: inline;"><input type="checkbox" name="basics_develop_software[]" value="basics_develop_software_prof"> Yes, professionally</label>
          <label style="display: inline;"><input type="checkbox" name="basics_develop_software[]" value="basics_develop_software_pet"> Yes, non-professionally -- e.g. pet projects, tinkering, ...</label>
          <label style="display: inline;"><input type="checkbox" name="basics_develop_software[]" value="basics_develop_software_oss"> Yes, I contribute to one or more open source projects (irrespective of size)</label>
        </div>
      </div>
      <div class="question">
        <div class="question-title">
          <em>3. </em>How long have you been programming?
        </div>
        <div class="question-comment">
        </div>
        <div class="question-input radios">
          <label style="display: inline;"><input type="radio" name="basics_develop_programming_tenure" value="basics_develop_programming_tenure_1"> 1 year or less</label>
          <label style="display: inline;"><input type="radio" name="basics_develop_programming_tenure" value="basics_develop_programming_tenure_2_5"> Between 2 and 5 years</label>
          <label style="display: inline;"><input type="radio" name="basics_develop_programming_tenure" value="basics_develop_programming_tenure_5_10"> Between 5 and 10 years</label>
          <label style="display: inline;"><input type="radio" name="basics_develop_programming_tenure" value="basics_develop_programming_tenure_10_20"> Between 10 and 20 years</label>
          <label style="display: inline;"><input type="radio" name="basics_develop_programming_tenure" value="basics_develop_programming_tenure_20"> More than 20 years</label>
        </div>
      </div>
      <div class="question">
        <div class="question-title">
          <label for="basics_github_proglangs"><em>4. </em>What programming <em>languages</em> do you use the majority of the time?</label>
        </div>
        <div class="question-comment"></div>
        <div class="question-input">
          <textarea name="basics_github_proglangs" id="basics_github_proglangs"></textarea>
        </div>
      </div>
      <div class="question">
        <div class="question-title">
          <label for="basics_github_progtools"><em>5. </em>What programming <em>tools</em> do you use the majority of the time?</label>
        </div>
        <div class="question-comment"></div>
        <div class="question-input">
          <textarea name="basics_github_progtools" id="basics_github_progtools"></textarea>
        </div>
      </div>
      <div class="question">
        <div class="question-title">
          <em>6. </em>How many <em>programming projects</em> have you contributed to or participated on (e.g. writing, reviewing code) during the past month?
        </div>
        <div class="question-comment">
        </div>
        <div class="question-input radios">
          <label style="display: inline;"><input type="radio" class="collab_projects" name="collab_projects" value="collab_projects_none"> None</label>
          <label style="display: inline;"><input type="radio" class="collab_projects" name="collab_projects" value="collab_projects_1"> 1</label>
          <label style="display: inline;"><input type="radio" class="collab_projects" name="collab_projects" value="collab_projects_2"> 2</label>
          <label style="display: inline;"><input type="radio" class="collab_projects" name="collab_projects" value="collab_projects_3"> 3</label>
          <label style="display: inline;"><input type="radio" class="collab_projects" name="collab_projects" value="collab_projects_4"> 4</label>
          <label style="display: inline;"><input type="radio" class="collab_projects" name="collab_projects" value="collab_projects_5"> 5</label>
          <label style="display: inline;"><input type="radio" class="collab_projects" name="collab_projects" value="collab_projects_other"> Other: <input type="text" name="collab_projects_other_text"></label>
        </div>
      </div>
      <div class="question" id="collab_team_smallest_container">
        <div class="question-title">
          <label for="collab_team_smallest"><em>6.1. </em>Of those projects, think of the one with the <em>smallest</em> number of developers you have interacted with. How many developers did you interact with on that project?</label>
        </div>
        <div class="question-comment"></div>
        <div class="question-input">
          <input type="text" name="collab_team_smallest" id="collab_team_smallest">
        </div>
      </div>
      <div class="question" id="collab_team_largest_container">
        <div class="question-title">
          <label for="collab_team_largest"><em>6.2. </em>Think of the one of those projects with the <em>largest</em> number of developers you have interacted with. How many developers did you interact with on that project?</label>
        </div>
        <div class="question-comment"></div>
        <div class="question-input">
          <input type="text" name="collab_team_largest" id="collab_team_largest">
        </div>
      </div>
      <h3>Keeping Up to Date</h3>
      <div class="question">
        <div class="question-title">
          <span class="label label-warning">Note:</span> <div class="note_description">The following questions all use the same grid of communication tools. Please focus on what each question is asking for; the options you can choose from are the same for every question. </div>
        </div>
      </div>
      <div class="question">
        <div class="question-title">
          <em>7. </em>The following help me stay <em>up to date</em> about technologies, practices and tools for software development.
        </div>
        <div class="question-comment">
          Please check all that apply.
        </div>
        <div class="question-input row">
          <div class="col-lg-4 col1">
            <label><input type="checkbox" name="up2date_up2date[]" value="up2date_up2date_f2f"> <div class="check_description">Face-to-face communication</div></label>
            <label><input type="checkbox" name="up2date_up2date[]" value="up2date_up2date_books"> <div class="check_description">Books and Magazines</div></label>
            <label><input type="checkbox" name="up2date_up2date[]" value="up2date_up2date_search"> <div class="check_description">Web Search <span class="examples">(Google, Bing, Duckduckgo, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_up2date[]" value="up2date_up2date_aggregators"> <div class="check_description">News Aggregators <span class="examples">(Hackernews, Reddit, Digg, Slashdot, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_up2date[]" value="up2date_up2date_feedsblogs"> <div class="check_description">Feeds and Blogs <span class="examples">(RSS, Feedly, Newsletters, blogs in general, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_up2date[]" value="up2date_up2date_recommenders"> <div class="check_description">Content Recommenders <span class="examples">(Stumble Upon, Prismatic, Flipboard, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_up2date[]" value="up2date_up2date_social_bookmarking"> <div class="check_description">Social Bookmarking <span class="examples">(Pinterest, Pinboard, Delicious, ...)</span></div></label>
          </div>
          <div class="col-lg-4 col2">
            <label><input type="checkbox" name="up2date_up2date[]" value="up2date_up2date_rich_content"> <div class="check_description">Rich Content <span class="examples">(Podcasts, Screencasts, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_up2date[]" value="up2date_up2date_discussion_groups"> <div class="check_description">Discussion Groups <span class="examples">(Google Groups, Usenet, Forums, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_up2date[]" value="up2date_up2date_private_discussions"> <div class="check_description">Private Discussions <span class="examples">(Email, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_up2date[]" value="up2date_up2date_public_chat"> <div class="check_description">Public Chat <span class="examples">(IRC, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_up2date[]" value="up2date_up2date_private_chat"> <div class="check_description">Private Chat <span class="examples">(IM, Skype Chat, Google Chat, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_up2date[]" value="up2date_up2date_professional_networking"> <div class="check_description">Professional Networking Sites <span class="examples">(LinkedIn, Xing, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_up2date[]" value="up2date_up2date_dev_profile_sites"> <div class="check_description">Developer Profile Sites <span class="examples">(Coderwall, Geekli.st, Masterbranch, ...)</span></div></label>
            <label><br>&nbsp;</label>
          </div>
          <div class="col-lg-4 col3">
            <label><input type="checkbox" name="up2date_up2date[]" value="up2date_up2date_sns"> <div class="check_description">Social Network Sites <span class="examples">(Facebook, Google Plus, vk.com, Diaspora, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_up2date[]" value="up2date_up2date_microblogs"> <div class="check_description">Microblogs <span class="examples">(Twitter, Tumblr, App.net, Sina Weibo, Plurk, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_up2date[]" value="up2date_up2date_code_hosting"> <div class="check_description">Code Hosting Sites <span class="examples">(GitHub, BitBucket, Launchpad, Google Code, Sourceforge, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_up2date[]" value="up2date_up2date_project_coord"> <div class="check_description">Project Coordination Tools <span class="examples">(Basecamp, Bugtrackers, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_up2date[]" value="up2date_up2date_qa_sites"> <div class="check_description">Question & Answer Sites <span class="examples">(Stack Overflow, Quora, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_up2date[]" value="up2date_up2date_other"> <div class="check_description">Other: <input type="text" name="up2date_up2date_other_text"></div></label>
          </div>
        </div>
      </div>
      <div class="question">
        <div class="question-title">
          <em>8. </em>The following help me <em>find answers</em> to technical questions.
        </div>
        <div class="question-comment">
          Please check all that apply.
        </div>
        <div class="question-input row">
          <div class="col-lg-4 col1">
            <label><input type="checkbox" name="up2date_answers[]" value="up2date_answers_f2f"> <div class="check_description">Face-to-face communication</div></label>
            <label><input type="checkbox" name="up2date_answers[]" value="up2date_answers_books"> <div class="check_description">Books and Magazines</div></label>
            <label><input type="checkbox" name="up2date_answers[]" value="up2date_answers_search"> <div class="check_description">Web Search <span class="examples">(Google, Bing, Duckduckgo, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_answers[]" value="up2date_answers_aggregators"> <div class="check_description">News Aggregators <span class="examples">(Hackernews, Reddit, Digg, Slashdot, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_answers[]" value="up2date_answers_feedsblogs"> <div class="check_description">Feeds and Blogs <span class="examples">(RSS, Feedly, Newsletters, blogs in general, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_answers[]" value="up2date_answers_recommenders"> <div class="check_description">Content Recommenders <span class="examples">(Stumble Upon, Prismatic, Flipboard, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_answers[]" value="up2date_answers_social_bookmarking"> <div class="check_description">Social Bookmarking <span class="examples">(Pinterest, Pinboard, Delicious, ...)</span></div></label>
          </div>
          <div class="col-lg-4 col2">
            <label><input type="checkbox" name="up2date_answers[]" value="up2date_answers_rich_content"> <div class="check_description">Rich Content <span class="examples">(Podcasts, Screencasts, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_answers[]" value="up2date_answers_discussion_groups"> <div class="check_description">Discussion Groups <span class="examples">(Google Groups, Usenet, Forums, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_answers[]" value="up2date_answers_private_discussions"> <div class="check_description">Private Discussions <span class="examples">(Email, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_answers[]" value="up2date_answers_public_chat"> <div class="check_description">Public Chat <span class="examples">(IRC, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_answers[]" value="up2date_answers_private_chat"> <div class="check_description">Private Chat <span class="examples">(IM, Skype Chat, Google Chat, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_answers[]" value="up2date_answers_professional_networking"> <div class="check_description">Professional Networking Sites <span class="examples">(LinkedIn, Xing, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_answers[]" value="up2date_answers_dev_profile_sites"> <div class="check_description">Developer Profile Sites <span class="examples">(Coderwall, Geekli.st, Masterbranch, ...)</span></div></label>
            <label><br>&nbsp;</label>
          </div>
          <div class="col-lg-4 col3">
            <label><input type="checkbox" name="up2date_answers[]" value="up2date_answers_sns"> <div class="check_description">Social Network Sites <span class="examples">(Facebook, Google Plus, vk.com, Diaspora, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_answers[]" value="up2date_answers_microblogs"> <div class="check_description">Microblogs <span class="examples">(Twitter, Tumblr, App.net, Sina Weibo, Plurk, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_answers[]" value="up2date_answers_code_hosting"> <div class="check_description">Code Hosting Sites <span class="examples">(GitHub, BitBucket, Launchpad, Google Code, Sourceforge, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_answers[]" value="up2date_answers_project_coord"> <div class="check_description">Project Coordination Tools <span class="examples">(Basecamp, Bugtrackers, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_answers[]" value="up2date_answers_qa_sites"> <div class="check_description">Question & Answer Sites <span class="examples">(Stack Overflow, Quora, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_answers[]" value="up2date_answers_other"> <div class="check_description">Other: <input type="text" name="up2date_answers_other_text"></div></label>
          </div>
        </div>
      </div>
      <div class="question">
        <div class="question-title">
          <em>9. </em>The following help me <em>learn</em> and improve my skills.
        </div>
        <div class="question-comment">
          Please check all that apply.
        </div>
        <div class="question-input row">
          <div class="col-lg-4 col1">
            <label><input type="checkbox" name="up2date_learn[]" value="up2date_learn_f2f"> <div class="check_description">Face-to-face communication</div></label>
            <label><input type="checkbox" name="up2date_learn[]" value="up2date_learn_books"> <div class="check_description">Books and Magazines</div></label>
            <label><input type="checkbox" name="up2date_learn[]" value="up2date_learn_search"> <div class="check_description">Web Search <span class="examples">(Google, Bing, Duckduckgo, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_learn[]" value="up2date_learn_aggregators"> <div class="check_description">News Aggregators <span class="examples">(Hackernews, Reddit, Digg, Slashdot, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_learn[]" value="up2date_learn_feedsblogs"> <div class="check_description">Feeds and Blogs <span class="examples">(RSS, Feedly, Newsletters, blogs in general, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_learn[]" value="up2date_learn_recommenders"> <div class="check_description">Content Recommenders <span class="examples">(Stumble Upon, Prismatic, Flipboard, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_learn[]" value="up2date_learn_social_bookmarking"> <div class="check_description">Social Bookmarking <span class="examples">(Pinterest, Pinboard, Delicious, ...)</span></div></label>
          </div>
          <div class="col-lg-4 col2">
            <label><input type="checkbox" name="up2date_learn[]" value="up2date_learn_rich_content"> <div class="check_description">Rich Content <span class="examples">(Podcasts, Screencasts, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_learn[]" value="up2date_learn_discussion_groups"> <div class="check_description">Discussion Groups <span class="examples">(Google Groups, Usenet, Forums, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_learn[]" value="up2date_learn_private_discussions"> <div class="check_description">Private Discussions <span class="examples">(Email, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_learn[]" value="up2date_learn_public_chat"> <div class="check_description">Public Chat <span class="examples">(IRC, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_learn[]" value="up2date_learn_private_chat"> <div class="check_description">Private Chat <span class="examples">(IM, Skype Chat, Google Chat, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_learn[]" value="up2date_learn_professional_networking"> <div class="check_description">Professional Networking Sites <span class="examples">(LinkedIn, Xing, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_learn[]" value="up2date_learn_dev_profile_sites"> <div class="check_description">Developer Profile Sites <span class="examples">(Coderwall, Geekli.st, Masterbranch, ...)</span></div></label>
            <label><br>&nbsp;</label>

          </div>
          <div class="col-lg-4 col3">
            <label><input type="checkbox" name="up2date_learn[]" value="up2date_learn_sns"> <div class="check_description">Social Network Sites <span class="examples">(Facebook, Google Plus, vk.com, Diaspora, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_learn[]" value="up2date_learn_microblogs"> <div class="check_description">Microblogs <span class="examples">(Twitter, Tumblr, App.net, Sina Weibo, Plurk, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_learn[]" value="up2date_learn_code_hosting"> <div class="check_description">Code Hosting Sites <span class="examples">(GitHub, BitBucket, Launchpad, Google Code, Sourceforge, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_learn[]" value="up2date_learn_project_coord"> <div class="check_description">Project Coordination Tools <span class="examples">(Basecamp, Bugtrackers, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_learn[]" value="up2date_learn_qa_sites"> <div class="check_description">Question & Answer Sites <span class="examples">(Stack Overflow, Quora, ...)</span></div></label>
            <label><input type="checkbox" name="up2date_learn[]" value="up2date_learn_other"> <div class="check_description">Other: <input type="text" name="up2date_learn_other_text"></div></label>
          </div>
        </div>
      </div>
      <h3>Relationships and Communication with Other Developers</h3>
      <div class="question">
        <div class="question-title">
          <em>10. </em>The following help me <em>discover</em> interesting developers.
        </div>
        <div class="question-comment">
          Please check all that apply.
        </div>
        <div class="question-input row">
          <div class="col-lg-4 col1">
            <label><input type="checkbox" name="rel_discover[]" value="rel_discover_f2f"> <div class="check_description">Face-to-face communication</div></label>
            <label><input type="checkbox" name="rel_discover[]" value="rel_discover_books"> <div class="check_description">Books and Magazines</div></label>
            <label><input type="checkbox" name="rel_discover[]" value="rel_discover_search"> <div class="check_description">Web Search <span class="examples">(Google, Bing, Duckduckgo, ...)</span></div></label>
            <label><input type="checkbox" name="rel_discover[]" value="rel_discover_aggregators"> <div class="check_description">News Aggregators <span class="examples">(Hackernews, Reddit, Digg, Slashdot, ...)</span></div></label>
            <label><input type="checkbox" name="rel_discover[]" value="rel_discover_feedsblogs"> <div class="check_description">Feeds and Blogs <span class="examples">(RSS, Feedly, Newsletters, blogs in general, ...)</span></div></label>
            <label><input type="checkbox" name="rel_discover[]" value="rel_discover_recommenders"> <div class="check_description">Content Recommenders <span class="examples">(Stumble Upon, Prismatic, Flipboard, ...)</span></div></label>
            <label><input type="checkbox" name="rel_discover[]" value="rel_discover_social_bookmarking"> <div class="check_description">Social Bookmarking <span class="examples">(Pinterest, Pinboard, Delicious, ...)</span></div></label>
          </div>
          <div class="col-lg-4 col2">
            <label><input type="checkbox" name="rel_discover[]" value="rel_discover_rich_content"> <div class="check_description">Rich Content <span class="examples">(Podcasts, Screencasts, ...)</span></div></label>
            <label><input type="checkbox" name="rel_discover[]" value="rel_discover_discussion_groups"> <div class="check_description">Discussion Groups <span class="examples">(Google Groups, Usenet, Forums, ...)</span></div></label>
            <label><input type="checkbox" name="rel_discover[]" value="rel_discover_private_discussions"> <div class="check_description">Private Discussions <span class="examples">(Email, ...)</span></div></label>
            <label><input type="checkbox" name="rel_discover[]" value="rel_discover_public_chat"> <div class="check_description">Public Chat <span class="examples">(IRC, ...)</span></div></label>
            <label><input type="checkbox" name="rel_discover[]" value="rel_discover_private_chat"> <div class="check_description">Private Chat <span class="examples">(IM, Skype Chat, Google Chat, ...)</span></div></label>
            <label><input type="checkbox" name="rel_discover[]" value="rel_discover_professional_networking"> <div class="check_description">Professional Networking Sites <span class="examples">(LinkedIn, Xing, ...)</span></div></label>
            <label><input type="checkbox" name="rel_discover[]" value="rel_discover_dev_profile_sites"> <div class="check_description">Developer Profile Sites <span class="examples">(Coderwall, Geekli.st, Masterbranch, ...)</span></div></label>
            <label><br>&nbsp;</label>
          </div>
          <div class="col-lg-4 col3">
            <label><input type="checkbox" name="rel_discover[]" value="rel_discover_sns"> <div class="check_description">Social Network Sites <span class="examples">(Facebook, Google Plus, vk.com, Diaspora, ...)</span></div></label>
            <label><input type="checkbox" name="rel_discover[]" value="rel_discover_microblogs"> <div class="check_description">Microblogs <span class="examples">(Twitter, Tumblr, App.net, Sina Weibo, Plurk, ...)</span></div></label>
            <label><input type="checkbox" name="rel_discover[]" value="rel_discover_code_hosting"> <div class="check_description">Code Hosting Sites <span class="examples">(GitHub, BitBucket, Launchpad, Google Code, Sourceforge, ...)</span></div></label>
            <label><input type="checkbox" name="rel_discover[]" value="rel_discover_project_coord"> <div class="check_description">Project Coordination Tools <span class="examples">(Basecamp, Bugtrackers, ...)</span></div></label>
            <label><input type="checkbox" name="rel_discover[]" value="rel_discover_qa_sites"> <div class="check_description">Question & Answer Sites <span class="examples">(Stack Overflow, Quora, ...)</span></div></label>
            <label><input type="checkbox" name="rel_discover[]" value="rel_discover_other"> <div class="check_description">Other: <input type="text" name="rel_discover_other_text"></div></label>
          </div>
        </div>
      </div>
      <div class="question">
        <div class="question-title">
          <em>11. </em>The following help me <em>connect</em> with interesting developers.
        </div>
        <div class="question-comment">
          Please check all that apply.
        </div>
        <div class="question-input row">
          <div class="col-lg-4 col1">
            <label><input type="checkbox" name="rel_connect[]" value="rel_connect_f2f"> <div class="check_description">Face-to-face communication</div></label>
            <label><input type="checkbox" name="rel_connect[]" value="rel_connect_books"> <div class="check_description">Books and Magazines</div></label>
            <label><input type="checkbox" name="rel_connect[]" value="rel_connect_search"> <div class="check_description">Web Search <span class="examples">(Google, Bing, Duckduckgo, ...)</span></div></label>
            <label><input type="checkbox" name="rel_connect[]" value="rel_connect_aggregators"> <div class="check_description">News Aggregators <span class="examples">(Hackernews, Reddit, Digg, Slashdot, ...)</span></div></label>
            <label><input type="checkbox" name="rel_connect[]" value="rel_connect_feedsblogs"> <div class="check_description">Feeds and Blogs <span class="examples">(RSS, Feedly, Newsletters, blogs in general, ...)</span></div></label>
            <label><input type="checkbox" name="rel_connect[]" value="rel_connect_recommenders"> <div class="check_description">Content Recommenders <span class="examples">(Stumble Upon, Prismatic, Flipboard, ...)</span></div></label>
            <label><input type="checkbox" name="rel_connect[]" value="rel_connect_social_bookmarking"> <div class="check_description">Social Bookmarking <span class="examples">(Pinterest, Pinboard, Delicious, ...)</span></div></label>
          </div>
          <div class="col-lg-4 col2">
            <label><input type="checkbox" name="rel_connect[]" value="rel_connect_rich_content"> <div class="check_description">Rich Content <span class="examples">(Podcasts, Screencasts, ...)</span></div></label>
            <label><input type="checkbox" name="rel_connect[]" value="rel_connect_discussion_groups"> <div class="check_description">Discussion Groups <span class="examples">(Google Groups, Usenet, Forums, ...)</span></div></label>
            <label><input type="checkbox" name="rel_connect[]" value="rel_connect_private_discussions"> <div class="check_description">Private Discussions <span class="examples">(Email, ...)</span></div></label>
            <label><input type="checkbox" name="rel_connect[]" value="rel_connect_public_chat"> <div class="check_description">Public Chat <span class="examples">(IRC, ...)</span></div></label>
            <label><input type="checkbox" name="rel_connect[]" value="rel_connect_private_chat"> <div class="check_description">Private Chat <span class="examples">(IM, Skype Chat, Google Chat, ...)</span></div></label>
            <label><input type="checkbox" name="rel_connect[]" value="rel_connect_professional_networking"> <div class="check_description">Professional Networking Sites <span class="examples">(LinkedIn, Xing, ...)</span></div></label>
            <label><input type="checkbox" name="rel_connect[]" value="rel_connect_dev_profile_sites"> <div class="check_description">Developer Profile Sites <span class="examples">(Coderwall, Geekli.st, Masterbranch, ...)</span></div></label>
            <label><br>&nbsp;</label>
          </div>
          <div class="col-lg-4 col3">
            <label><input type="checkbox" name="rel_connect[]" value="rel_connect_sns"> <div class="check_description">Social Network Sites <span class="examples">(Facebook, Google Plus, vk.com, Diaspora, ...)</span></div></label>
            <label><input type="checkbox" name="rel_connect[]" value="rel_connect_microblogs"> <div class="check_description">Microblogs <span class="examples">(Twitter, Tumblr, App.net, Sina Weibo, Plurk, ...)</span></div></label>
            <label><input type="checkbox" name="rel_connect[]" value="rel_connect_code_hosting"> <div class="check_description">Code Hosting Sites <span class="examples">(GitHub, BitBucket, Launchpad, Google Code, Sourceforge, ...)</span></div></label>
            <label><input type="checkbox" name="rel_connect[]" value="rel_connect_project_coord"> <div class="check_description">Project Coordination Tools <span class="examples">(Basecamp, Bugtrackers, ...)</span></div></label>
            <label><input type="checkbox" name="rel_connect[]" value="rel_connect_qa_sites"> <div class="check_description">Question & Answer Sites <span class="examples">(Stack Overflow, Quora, ...)</span></div></label>
            <label><input type="checkbox" name="rel_connect[]" value="rel_connect_other"> <div class="check_description">Other: <input type="text" name="rel_connect_other_text"></div></label>
          </div>
        </div>
      </div>
      <div class="question">
        <div class="question-title">
          <em>12. </em>The following are useful for getting and giving <em>feedback</em>.
        </div>
        <div class="question-comment">
          Please check all that apply.
        </div>
        <div class="question-input row">
          <div class="col-lg-4 col1">
            <label><input type="checkbox" name="rel_feedback[]" value="rel_feedback_f2f"> <div class="check_description">Face-to-face communication</div></label>
            <label><input type="checkbox" name="rel_feedback[]" value="rel_feedback_books"> <div class="check_description">Books and Magazines</div></label>
            <label><input type="checkbox" name="rel_feedback[]" value="rel_feedback_search"> <div class="check_description">Web Search <span class="examples">(Google, Bing, Duckduckgo, ...)</span></div></label>
            <label><input type="checkbox" name="rel_feedback[]" value="rel_feedback_aggregators"> <div class="check_description">News Aggregators <span class="examples">(Hackernews, Reddit, Digg, Slashdot, ...)</span></div></label>
            <label><input type="checkbox" name="rel_feedback[]" value="rel_feedback_feedsblogs"> <div class="check_description">Feeds and Blogs <span class="examples">(RSS, Feedly, Newsletters, blogs in general, ...)</span></div></label>
            <label><input type="checkbox" name="rel_feedback[]" value="rel_feedback_recommenders"> <div class="check_description">Content Recommenders <span class="examples">(Stumble Upon, Prismatic, Flipboard, ...)</span></div></label>
            <label><input type="checkbox" name="rel_feedback[]" value="rel_feedback_social_bookmarking"> <div class="check_description">Social Bookmarking <span class="examples">(Pinterest, Pinboard, Delicious, ...)</span></div></label>
          </div>
          <div class="col-lg-4 col2">
            <label><input type="checkbox" name="rel_feedback[]" value="rel_feedback_rich_content"> <div class="check_description">Rich Content <span class="examples">(Podcasts, Screencasts, ...)</span></div></label>
            <label><input type="checkbox" name="rel_feedback[]" value="rel_feedback_discussion_groups"> <div class="check_description">Discussion Groups <span class="examples">(Google Groups, Usenet, Forums, ...)</span></div></label>
            <label><input type="checkbox" name="rel_feedback[]" value="rel_feedback_private_discussions"> <div class="check_description">Private Discussions <span class="examples">(Email, ...)</span></div></label>
            <label><input type="checkbox" name="rel_feedback[]" value="rel_feedback_public_chat"> <div class="check_description">Public Chat <span class="examples">(IRC, ...)</span></div></label>
            <label><input type="checkbox" name="rel_feedback[]" value="rel_feedback_private_chat"> <div class="check_description">Private Chat <span class="examples">(IM, Skype Chat, Google Chat, ...)</span></div></label>
            <label><input type="checkbox" name="rel_feedback[]" value="rel_feedback_professional_networking"> <div class="check_description">Professional Networking Sites <span class="examples">(LinkedIn, Xing, ...)</span></div></label>
            <label><input type="checkbox" name="rel_feedback[]" value="rel_feedback_dev_profile_sites"> <div class="check_description">Developer Profile Sites <span class="examples">(Coderwall, Geekli.st, Masterbranch, ...)</span></div></label>
            <label><br>&nbsp;</label>
          </div>
          <div class="col-lg-4 col3">
            <label><input type="checkbox" name="rel_feedback[]" value="rel_feedback_sns"> <div class="check_description">Social Network Sites <span class="examples">(Facebook, Google Plus, vk.com, Diaspora, ...)</span></div></label>
            <label><input type="checkbox" name="rel_feedback[]" value="rel_feedback_microblogs"> <div class="check_description">Microblogs <span class="examples">(Twitter, Tumblr, App.net, Sina Weibo, Plurk, ...)</span></div></label>
            <label><input type="checkbox" name="rel_feedback[]" value="rel_feedback_code_hosting"> <div class="check_description">Code Hosting Sites <span class="examples">(GitHub, BitBucket, Launchpad, Google Code, Sourceforge, ...)</span></div></label>
            <label><input type="checkbox" name="rel_feedback[]" value="rel_feedback_project_coord"> <div class="check_description">Project Coordination Tools <span class="examples">(Basecamp, Bugtrackers, ...)</span></div></label>
            <label><input type="checkbox" name="rel_feedback[]" value="rel_feedback_qa_sites"> <div class="check_description">Question & Answer Sites <span class="examples">(Stack Overflow, Quora, ...)</span></div></label>
            <label><input type="checkbox" name="rel_feedback[]" value="rel_feedback_other"> <div class="check_description">Other: <input type="text" name="rel_feedback_other_text"></div></label>
          </div>
        </div>
      </div>
      <h3>Developer Profiles</h3>
      <div class="question">
        <div class="question-title">
          <em>13. </em>I use the following to <em>publish</em> my development activities.
        </div>
        <div class="question-comment">
          Please check all that apply.
        </div>
        <div class="question-input row">
          <div class="col-lg-4 col1">
            <label><input type="checkbox" name="profiles_publish[]" value="profiles_publish_f2f"> <div class="check_description">Face-to-face communication</div></label>
            <label><input type="checkbox" name="profiles_publish[]" value="profiles_publish_books"> <div class="check_description">Books and Magazines</div></label>
            <label><input type="checkbox" name="profiles_publish[]" value="profiles_publish_search"> <div class="check_description">Web Search <span class="examples">(Google, Bing, Duckduckgo, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_publish[]" value="profiles_publish_aggregators"> <div class="check_description">News Aggregators <span class="examples">(Hackernews, Reddit, Digg, Slashdot, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_publish[]" value="profiles_publish_feedsblogs"> <div class="check_description">Feeds and Blogs <span class="examples">(RSS, Feedly, Newsletters, blogs in general, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_publish[]" value="profiles_publish_recommenders"> <div class="check_description">Content Recommenders <span class="examples">(Stumble Upon, Prismatic, Flipboard, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_publish[]" value="profiles_publish_social_bookmarking"> <div class="check_description">Social Bookmarking <span class="examples">(Pinterest, Pinboard, Delicious, ...)</span></div></label>
          </div>
          <div class="col-lg-4 col2">
            <label><input type="checkbox" name="profiles_publish[]" value="profiles_publish_rich_content"> <div class="check_description">Rich Content <span class="examples">(Podcasts, Screencasts, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_publish[]" value="profiles_publish_discussion_groups"> <div class="check_description">Discussion Groups <span class="examples">(Google Groups, Usenet, Forums, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_publish[]" value="profiles_publish_private_discussions"> <div class="check_description">Private Discussions <span class="examples">(Email, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_publish[]" value="profiles_publish_public_chat"> <div class="check_description">Public Chat <span class="examples">(IRC, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_publish[]" value="profiles_publish_private_chat"> <div class="check_description">Private Chat <span class="examples">(IM, Skype Chat, Google Chat, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_publish[]" value="profiles_publish_professional_networking"> <div class="check_description">Professional Networking Sites <span class="examples">(LinkedIn, Xing, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_publish[]" value="profiles_publish_dev_profile_sites"> <div class="check_description">Developer Profile Sites <span class="examples">(Coderwall, Geekli.st, Masterbranch, ...)</span></div></label>
            <label><br>&nbsp;</label>
          </div>
          <div class="col-lg-4 col3">
            <label><input type="checkbox" name="profiles_publish[]" value="profiles_publish_sns"> <div class="check_description">Social Network Sites <span class="examples">(Facebook, Google Plus, vk.com, Diaspora, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_publish[]" value="profiles_publish_microblogs"> <div class="check_description">Microblogs <span class="examples">(Twitter, Tumblr, App.net, Sina Weibo, Plurk, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_publish[]" value="profiles_publish_code_hosting"> <div class="check_description">Code Hosting Sites <span class="examples">(GitHub, BitBucket, Launchpad, Google Code, Sourceforge, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_publish[]" value="profiles_publish_project_coord"> <div class="check_description">Project Coordination Tools <span class="examples">(Basecamp, Bugtrackers, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_publish[]" value="profiles_publish_qa_sites"> <div class="check_description">Question & Answer Sites <span class="examples">(Stack Overflow, Quora, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_publish[]" value="profiles_publish_other"> <div class="check_description">Other: <input type="text" name="profiles_publish_other_text"></div></label>
          </div>
        </div>
      </div>
      <div class="question">
        <div class="question-title">
          <em>14. </em>I use the following to <em>watch</em> other developers' activities.
        </div>
        <div class="question-comment">
          Please check all that apply.
        </div>
        <div class="question-input row">
          <div class="col-lg-4 col1">
            <label><input type="checkbox" name="profiles_watch[]" value="profiles_watch_f2f"> <div class="check_description">Face-to-face communication</div></label>
            <label><input type="checkbox" name="profiles_watch[]" value="profiles_watch_books"> <div class="check_description">Books and Magazines</div></label>
            <label><input type="checkbox" name="profiles_watch[]" value="profiles_watch_search"> <div class="check_description">Web Search <span class="examples">(Google, Bing, Duckduckgo, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_watch[]" value="profiles_watch_aggregators"> <div class="check_description">News Aggregators <span class="examples">(Hackernews, Reddit, Digg, Slashdot, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_watch[]" value="profiles_watch_feedsblogs"> <div class="check_description">Feeds and Blogs <span class="examples">(RSS, Feedly, Newsletters, blogs in general, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_watch[]" value="profiles_watch_recommenders"> <div class="check_description">Content Recommenders <span class="examples">(Stumble Upon, Prismatic, Flipboard, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_watch[]" value="profiles_watch_social_bookmarking"> <div class="check_description">Social Bookmarking <span class="examples">(Pinterest, Pinboard, Delicious, ...)</span></div></label>
          </div>
          <div class="col-lg-4 col2">
            <label><input type="checkbox" name="profiles_watch[]" value="profiles_watch_rich_content"> <div class="check_description">Rich Content <span class="examples">(Podcasts, Screencasts, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_watch[]" value="profiles_watch_discussion_groups"> <div class="check_description">Discussion Groups <span class="examples">(Google Groups, Usenet, Forums, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_watch[]" value="profiles_watch_private_discussions"> <div class="check_description">Private Discussions <span class="examples">(Email, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_watch[]" value="profiles_watch_public_chat"> <div class="check_description">Public Chat <span class="examples">(IRC, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_watch[]" value="profiles_watch_private_chat"> <div class="check_description">Private Chat <span class="examples">(IM, Skype Chat, Google Chat, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_watch[]" value="profiles_watch_professional_networking"> <div class="check_description">Professional Networking Sites <span class="examples">(LinkedIn, Xing, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_watch[]" value="profiles_watch_dev_profile_sites"> <div class="check_description">Developer Profile Sites <span class="examples">(Coderwall, Geekli.st, Masterbranch, ...)</span></div></label>
            <label><br>&nbsp;</label>
          </div>
          <div class="col-lg-4 col3">
            <label><input type="checkbox" name="profiles_watch[]" value="profiles_watch_sns"> <div class="check_description">Social Network Sites <span class="examples">(Facebook, Google Plus, vk.com, Diaspora, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_watch[]" value="profiles_watch_microblogs"> <div class="check_description">Microblogs <span class="examples">(Twitter, Tumblr, App.net, Sina Weibo, Plurk, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_watch[]" value="profiles_watch_code_hosting"> <div class="check_description">Code Hosting Sites <span class="examples">(GitHub, BitBucket, Launchpad, Google Code, Sourceforge, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_watch[]" value="profiles_watch_project_coord"> <div class="check_description">Project Coordination Tools <span class="examples">(Basecamp, Bugtrackers, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_watch[]" value="profiles_watch_qa_sites"> <div class="check_description">Question & Answer Sites <span class="examples">(Stack Overflow, Quora, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_watch[]" value="profiles_watch_other"> <div class="check_description">Other: <input type="text" name="profiles_watch_other_text"></div></label>
          </div>
        </div>
      </div>
      <div class="question">
        <div class="question-title">
          <em>15. </em>I use the following to display my <em>skills/accomplishments</em>.
        </div>
        <div class="question-comment">
          Please check all that apply.
        </div>
        <div class="question-input row">
          <div class="col-lg-4 col1">
            <label><input type="checkbox" name="profiles_display[]" value="profiles_display_f2f"> <div class="check_description">Face-to-face communication</div></label>
            <label><input type="checkbox" name="profiles_display[]" value="profiles_display_books"> <div class="check_description">Books and Magazines</div></label>
            <label><input type="checkbox" name="profiles_display[]" value="profiles_display_search"> <div class="check_description">Web Search <span class="examples">(Google, Bing, Duckduckgo, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_display[]" value="profiles_display_aggregators"> <div class="check_description">News Aggregators <span class="examples">(Hackernews, Reddit, Digg, Slashdot, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_display[]" value="profiles_display_feedsblogs"> <div class="check_description">Feeds and Blogs <span class="examples">(RSS, Feedly, Newsletters, blogs in general, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_display[]" value="profiles_display_recommenders"> <div class="check_description">Content Recommenders <span class="examples">(Stumble Upon, Prismatic, Flipboard, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_display[]" value="profiles_display_social_bookmarking"> <div class="check_description">Social Bookmarking <span class="examples">(Pinterest, Pinboard, Delicious, ...)</span></div></label>
          </div>
          <div class="col-lg-4 col2">
            <label><input type="checkbox" name="profiles_display[]" value="profiles_display_rich_content"> <div class="check_description">Rich Content <span class="examples">(Podcasts, Screencasts, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_display[]" value="profiles_display_discussion_groups"> <div class="check_description">Discussion Groups <span class="examples">(Google Groups, Usenet, Forums, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_display[]" value="profiles_display_private_discussions"> <div class="check_description">Private Discussions <span class="examples">(Email, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_display[]" value="profiles_display_public_chat"> <div class="check_description">Public Chat <span class="examples">(IRC, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_display[]" value="profiles_display_private_chat"> <div class="check_description">Private Chat <span class="examples">(IM, Skype Chat, Google Chat, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_display[]" value="profiles_display_professional_networking"> <div class="check_description">Professional Networking Sites <span class="examples">(LinkedIn, Xing, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_display[]" value="profiles_display_dev_profile_sites"> <div class="check_description">Developer Profile Sites <span class="examples">(Coderwall, Geekli.st, Masterbranch, ...)</span></div></label>
            <label><br>&nbsp;</label>
          </div>
          <div class="col-lg-4 col3">
            <label><input type="checkbox" name="profiles_display[]" value="profiles_display_sns"> <div class="check_description">Social Network Sites <span class="examples">(Facebook, Google Plus, vk.com, Diaspora, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_display[]" value="profiles_display_microblogs"> <div class="check_description">Microblogs <span class="examples">(Twitter, Tumblr, App.net, Sina Weibo, Plurk, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_display[]" value="profiles_display_code_hosting"> <div class="check_description">Code Hosting Sites <span class="examples">(GitHub, BitBucket, Launchpad, Google Code, Sourceforge, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_display[]" value="profiles_display_project_coord"> <div class="check_description">Project Coordination Tools <span class="examples">(Basecamp, Bugtrackers, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_display[]" value="profiles_display_qa_sites"> <div class="check_description">Question & Answer Sites <span class="examples">(Stack Overflow, Quora, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_display[]" value="profiles_display_other"> <div class="check_description">Other: <input type="text" name="profiles_display_other_text"></div></label>
          </div>
        </div>
      </div>
      <div class="question">
        <div class="question-title">
          <em>16. </em>I use the following to <em>assess</em> other developers.
        </div>
        <div class="question-comment">
          Please check all that apply.
        </div>
        <div class="question-input row">
          <div class="col-lg-4 col1">
            <label><input type="checkbox" name="profiles_assess[]" value="profiles_assess_f2f"> <div class="check_description">Face-to-face communication</div></label>
            <label><input type="checkbox" name="profiles_assess[]" value="profiles_assess_books"> <div class="check_description">Books and Magazines</div></label>
            <label><input type="checkbox" name="profiles_assess[]" value="profiles_assess_search"> <div class="check_description">Web Search <span class="examples">(Google, Bing, Duckduckgo, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_assess[]" value="profiles_assess_aggregators"> <div class="check_description">News Aggregators <span class="examples">(Hackernews, Reddit, Digg, Slashdot, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_assess[]" value="profiles_assess_feedsblogs"> <div class="check_description">Feeds and Blogs <span class="examples">(RSS, Feedly, Newsletters, blogs in general, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_assess[]" value="profiles_assess_recommenders"> <div class="check_description">Content Recommenders <span class="examples">(Stumble Upon, Prismatic, Flipboard, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_assess[]" value="profiles_assess_social_bookmarking"> <div class="check_description">Social Bookmarking <span class="examples">(Pinterest, Pinboard, Delicious, ...)</span></div></label>
          </div>
          <div class="col-lg-4 col2">
            <label><input type="checkbox" name="profiles_assess[]" value="profiles_assess_rich_content"> <div class="check_description">Rich Content <span class="examples">(Podcasts, Screencasts, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_assess[]" value="profiles_assess_discussion_groups"> <div class="check_description">Discussion Groups <span class="examples">(Google Groups, Usenet, Forums, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_assess[]" value="profiles_assess_private_discussions"> <div class="check_description">Private Discussions <span class="examples">(Email, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_assess[]" value="profiles_assess_public_chat"> <div class="check_description">Public Chat <span class="examples">(IRC, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_assess[]" value="profiles_assess_private_chat"> <div class="check_description">Private Chat <span class="examples">(IM, Skype Chat, Google Chat, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_assess[]" value="profiles_assess_professional_networking"> <div class="check_description">Professional Networking Sites <span class="examples">(LinkedIn, Xing, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_assess[]" value="profiles_assess_dev_profile_sites"> <div class="check_description">Developer Profile Sites <span class="examples">(Coderwall, Geekli.st, Masterbranch, ...)</span></div></label>
            <label><br>&nbsp;</label>
          </div>
          <div class="col-lg-4 col3">
            <label><input type="checkbox" name="profiles_assess[]" value="profiles_assess_sns"> <div class="check_description">Social Network Sites <span class="examples">(Facebook, Google Plus, vk.com, Diaspora, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_assess[]" value="profiles_assess_microblogs"> <div class="check_description">Microblogs <span class="examples">(Twitter, Tumblr, App.net, Sina Weibo, Plurk, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_assess[]" value="profiles_assess_code_hosting"> <div class="check_description">Code Hosting Sites <span class="examples">(GitHub, BitBucket, Launchpad, Google Code, Sourceforge, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_assess[]" value="profiles_assess_project_coord"> <div class="check_description">Project Coordination Tools <span class="examples">(Basecamp, Bugtrackers, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_assess[]" value="profiles_assess_qa_sites"> <div class="check_description">Question & Answer Sites <span class="examples">(Stack Overflow, Quora, ...)</span></div></label>
            <label><input type="checkbox" name="profiles_assess[]" value="profiles_assess_other"> <div class="check_description">Other: <input type="text" name="profiles_assess_other_text"></div></label>
          </div>
        </div>
      </div>
      <h3>Collaborating on Code</h3>
      <div class="question">
        <div class="question-title">
          <em>17. </em>I use the following tools to <em>coordinate</em> with other developers when I am participating on projects.
        </div>
        <div class="question-comment">
          Please check all that apply.
        </div>
        <div class="question-input row">
          <div class="col-lg-4 col1">
            <label><input type="checkbox" name="collab_coord[]" value="collab_coord_f2f"> <div class="check_description">Face-to-face communication</div></label>
            <label><input type="checkbox" name="collab_coord[]" value="collab_coord_books"> <div class="check_description">Books and Magazines</div></label>
            <label><input type="checkbox" name="collab_coord[]" value="collab_coord_search"> <div class="check_description">Web Search <span class="examples">(Google, Bing, Duckduckgo, ...)</span></div></label>
            <label><input type="checkbox" name="collab_coord[]" value="collab_coord_aggregators"> <div class="check_description">News Aggregators <span class="examples">(Hackernews, Reddit, Digg, Slashdot, ...)</span></div></label>
            <label><input type="checkbox" name="collab_coord[]" value="collab_coord_feedsblogs"> <div class="check_description">Feeds and Blogs <span class="examples">(RSS, Feedly, Newsletters, blogs in general, ...)</span></div></label>
            <label><input type="checkbox" name="collab_coord[]" value="collab_coord_recommenders"> <div class="check_description">Content Recommenders <span class="examples">(Stumble Upon, Prismatic, Flipboard, ...)</span></div></label>
            <label><input type="checkbox" name="collab_coord[]" value="collab_coord_social_bookmarking"> <div class="check_description">Social Bookmarking <span class="examples">(Pinterest, Pinboard, Delicious, ...)</span></div></label>
          </div>
          <div class="col-lg-4 col2">
            <label><input type="checkbox" name="collab_coord[]" value="collab_coord_rich_content"> <div class="check_description">Rich Content <span class="examples">(Podcasts, Screencasts, ...)</span></div></label>
            <label><input type="checkbox" name="collab_coord[]" value="collab_coord_discussion_groups"> <div class="check_description">Discussion Groups <span class="examples">(Google Groups, Usenet, Forums, ...)</span></div></label>
            <label><input type="checkbox" name="collab_coord[]" value="collab_coord_private_discussions"> <div class="check_description">Private Discussions <span class="examples">(Email, ...)</span></div></label>
            <label><input type="checkbox" name="collab_coord[]" value="collab_coord_public_chat"> <div class="check_description">Public Chat <span class="examples">(IRC, ...)</span></div></label>
            <label><input type="checkbox" name="collab_coord[]" value="collab_coord_private_chat"> <div class="check_description">Private Chat <span class="examples">(IM, Skype Chat, Google Chat, ...)</span></div></label>
            <label><input type="checkbox" name="collab_coord[]" value="collab_coord_professional_networking"> <div class="check_description">Professional Networking Sites <span class="examples">(LinkedIn, Xing, ...)</span></div></label>
            <label><input type="checkbox" name="collab_coord[]" value="collab_coord_dev_profile_sites"> <div class="check_description">Developer Profile Sites <span class="examples">(Coderwall, Geekli.st, Masterbranch, ...)</span></div></label>
            <label><br>&nbsp;</label>
          </div>
          <div class="col-lg-4 col3">
            <label><input type="checkbox" name="collab_coord[]" value="collab_coord_sns"> <div class="check_description">Social Network Sites <span class="examples">(Facebook, Google Plus, vk.com, Diaspora, ...)</span></div></label>
            <label><input type="checkbox" name="collab_coord[]" value="collab_coord_microblogs"> <div class="check_description">Microblogs <span class="examples">(Twitter, Tumblr, App.net, Sina Weibo, Plurk, ...)</span></div></label>
            <label><input type="checkbox" name="collab_coord[]" value="collab_coord_code_hosting"> <div class="check_description">Code Hosting Sites <span class="examples">(GitHub, BitBucket, Launchpad, Google Code, Sourceforge, ...)</span></div></label>
            <label><input type="checkbox" name="collab_coord[]" value="collab_coord_project_coord"> <div class="check_description">Project Coordination Tools <span class="examples">(Basecamp, Bugtrackers, ...)</span></div></label>
            <label><input type="checkbox" name="collab_coord[]" value="collab_coord_qa_sites"> <div class="check_description">Question & Answer Sites <span class="examples">(Stack Overflow, Quora, ...)</span></div></label>
            <label><input type="checkbox" name="collab_coord[]" value="collab_coord_other"> <div class="check_description">Other: <input type="text" name="collab_coord_other_text"></div></label>
          </div>
        </div>
      </div>
      <h3>Mobile Use</h3>
      <div class="question">
        <div class="question-title">
          <em>18. </em>I use the following tools on a <em>mobile device</em> (smartphone, tablet) for development-related activities.
        </div>
        <div class="question-comment">
          Please check all that apply.
        </div>
        <div class="question-input row">
          <div class="col-lg-4 col1">
            <label><input type="checkbox" name="mobile_use[]" value="mobile_use_f2f"> <div class="check_description">Face-to-face communication</div></label>
            <label><input type="checkbox" name="mobile_use[]" value="mobile_use_books"> <div class="check_description">Books and Magazines</div></label>
            <label><input type="checkbox" name="mobile_use[]" value="mobile_use_search"> <div class="check_description">Web Search <span class="examples">(Google, Bing, Duckduckgo, ...)</span></div></label>
            <label><input type="checkbox" name="mobile_use[]" value="mobile_use_aggregators"> <div class="check_description">News Aggregators <span class="examples">(Hackernews, Reddit, Digg, Slashdot, ...)</span></div></label>
            <label><input type="checkbox" name="mobile_use[]" value="mobile_use_feedsblogs"> <div class="check_description">Feeds and Blogs <span class="examples">(RSS, Feedly, Newsletters, blogs in general, ...)</span></div></label>
            <label><input type="checkbox" name="mobile_use[]" value="mobile_use_recommenders"> <div class="check_description">Content Recommenders <span class="examples">(Stumble Upon, Prismatic, Flipboard, ...)</span></div></label>
            <label><input type="checkbox" name="mobile_use[]" value="mobile_use_social_bookmarking"> <div class="check_description">Social Bookmarking <span class="examples">(Pinterest, Pinboard, Delicious, ...)</span></div></label>
          </div>
          <div class="col-lg-4 col2">
            <label><input type="checkbox" name="mobile_use[]" value="mobile_use_rich_content"> <div class="check_description">Rich Content <span class="examples">(Podcasts, Screencasts, ...)</span></div></label>
            <label><input type="checkbox" name="mobile_use[]" value="mobile_use_discussion_groups"> <div class="check_description">Discussion Groups <span class="examples">(Google Groups, Usenet, Forums, ...)</span></div></label>
            <label><input type="checkbox" name="mobile_use[]" value="mobile_use_private_discussions"> <div class="check_description">Private Discussions <span class="examples">(Email, ...)</span></div></label>
            <label><input type="checkbox" name="mobile_use[]" value="mobile_use_public_chat"> <div class="check_description">Public Chat <span class="examples">(IRC, ...)</span></div></label>
            <label><input type="checkbox" name="mobile_use[]" value="mobile_use_private_chat"> <div class="check_description">Private Chat <span class="examples">(IM, Skype Chat, Google Chat, ...)</span></div></label>
            <label><input type="checkbox" name="mobile_use[]" value="mobile_use_professional_networking"> <div class="check_description">Professional Networking Sites <span class="examples">(LinkedIn, Xing, ...)</span></div></label>
            <label><input type="checkbox" name="mobile_use[]" value="mobile_use_dev_profile_sites"> <div class="check_description">Developer Profile Sites <span class="examples">(Coderwall, Geekli.st, Masterbranch, ...)</span></div></label>
            <label><br>&nbsp;</label>
          </div>
          <div class="col-lg-4 col3">
            <label><input type="checkbox" name="mobile_use[]" value="mobile_use_sns"> <div class="check_description">Social Network Sites <span class="examples">(Facebook, Google Plus, vk.com, Diaspora, ...)</span></div></label>
            <label><input type="checkbox" name="mobile_use[]" value="mobile_use_microblogs"> <div class="check_description">Microblogs <span class="examples">(Twitter, Tumblr, App.net, Sina Weibo, Plurk, ...)</span></div></label>
            <label><input type="checkbox" name="mobile_use[]" value="mobile_use_code_hosting"> <div class="check_description">Code Hosting Sites <span class="examples">(GitHub, BitBucket, Launchpad, Google Code, Sourceforge, ...)</span></div></label>
            <label><input type="checkbox" name="mobile_use[]" value="mobile_use_project_coord"> <div class="check_description">Project Coordination Tools <span class="examples">(Basecamp, Bugtrackers, ...)</span></div></label>
            <label><input type="checkbox" name="mobile_use[]" value="mobile_use_qa_sites"> <div class="check_description">Question & Answer Sites <span class="examples">(Stack Overflow, Quora, ...)</span></div></label>
            <label><input type="checkbox" name="mobile_use[]" value="mobile_use_other"> <div class="check_description">Other: <input type="text" name="mobile_use_other_text"></div></label>
          </div>
        </div>
      </div>
      <h3>Challenges</h3>
      <div class="question">
        <div class="question-title">
          <em>19. </em>I frequently feel <em>overwhelmed</em> by the amount of software engineering information I receive from the communication and social tools I discussed above.
        </div>
        <div class="question-comment"></div>
        <div class="question-input likert">
          Strongly Disagree <input type="radio" name="challenges_overwhelm" value="challenges_overwhelm_1"> <input type="radio" name="challenges_overwhelm" value="challenges_overwhelm_2"> <input type="radio" name="challenges_overwhelm" value="challenges_overwhelm_3"> <input type="radio" name="challenges_overwhelm" value="challenges_overwhelm_4"> <input type="radio" name="challenges_overwhelm" value="challenges_overwhelm_5"> <input type="radio" name="challenges_overwhelm" value="challenges_overwhelm_6"> <input type="radio" name="challenges_overwhelm" value="challenges_overwhelm_7"> Strongly Agree
        </div>
      </div>
      <div class="question">
        <div class="question-title">
          <em>20. </em>I worry about <em>privacy</em> when I use tools for spreading information about software development.
        </div>
        <div class="question-comment"></div>
        <div class="question-input likert">
          Strongly Disagree <input type="radio" name="challenges_privacy" value="challenges_privacy_1"> <input type="radio" name="challenges_privacy" value="challenges_privacy_2"> <input type="radio" name="challenges_privacy" value="challenges_privacy_3"> <input type="radio" name="challenges_privacy" value="challenges_privacy_4"> <input type="radio" name="challenges_privacy" value="challenges_privacy_5"> <input type="radio" name="challenges_privacy" value="challenges_privacy_6"> <input type="radio" name="challenges_privacy" value="challenges_privacy_7"> Strongly Agree
        </div>
      </div>
      <div class="question">
        <div class="question-title">
          <em>21. </em>I frequently find that communication and social tools can be a <em>distraction</em> during software development.
        </div>
        <div class="question-comment"></div>
        <div class="question-input likert">
          Strongly Disagree <input type="radio" name="challenges_distract" value="challenges_distract_1"> <input type="radio" name="challenges_distract" value="challenges_distract_2"> <input type="radio" name="challenges_distract" value="challenges_distract_3"> <input type="radio" name="challenges_distract" value="challenges_distract_4"> <input type="radio" name="challenges_distract" value="challenges_distract_5"> <input type="radio" name="challenges_distract" value="challenges_distract_6"> <input type="radio" name="challenges_distract" value="challenges_distract_7"> Strongly Agree
        </div>
      </div>
      <div class="question">
        <div class="question-title">
          <label for="challenges_other"><em>22. </em>Do you experience any <em>other challenges</em> with the use of communication and social tools during software development? If so, could you briefly explain those challenges?</label>
        </div>
        <div class="question-comment"></div>
        <div class="question-input">
          <textarea name="challenges_other" id="challenges_other"></textarea>
        </div>
      </div>
      <h3>Closing</h3>
      <div class="question">
        <div class="question-title">
          Please choose the <em>3 most important channels</em> for your software development activities. Why are these so important?
        </div>
        <div class="question-input row">
          <em>1.</em>
          <select name="closing_important_1">
            <option value="closing_important_1_na">Please choose ...</option>
            <option value="closing_important_1_f2f">Face-to-face communication</option>
            <option value="closing_important_1_books">Books and Magazines</option>
            <option value="closing_important_1_search">Web Search (Google, Bing, Duckduckgo, ...)</option>
            <option value="closing_important_1_aggregators">News Aggregators (Hackernews, Reddit, Digg, Slashdot, ...)</option>
            <option value="closing_important_1_feedsblogs">Feeds and Blogs (RSS, Feedly, Newsletters, blogs in general, ...)</option>
            <option value="closing_important_1_recommenders">Content Recommenders (Stumble Upon, Prismatic, Flipboard, ...)</option>
            <option value="closing_important_1_social_bookmarking">Social Bookmarking (Pinterest, Pinboard, Delicious, ...)</option>
            <option value="closing_important_1_rich_content">Rich Content (Podcasts, Screencasts, ...)</option>
            <option value="closing_important_1_discussion_groups">Discussion Groups (Google Groups, Usenet, Forums, ...)</option>
            <option value="closing_important_1_private_discussions">Private Discussions (Email, ...)</option>
            <option value="closing_important_1_public_chat">Public Chat (IRC, ...)</option>
            <option value="closing_important_1_private_chat">Private Chat (IM, Skype Chat, Google Chat, ...)</option>
            <option value="closing_important_1_professional_networking">Professional Networking Sites (LinkedIn, Xing, ...)</option>
            <option value="closing_important_1_dev_profile_sites">Developer Profile Sites (Coderwall, Geekli.st, Masterbranch, ...)</option>
            <option value="closing_important_1_sns">Social Network Sites (Facebook, Google Plus, vk.com, Diaspora, ...)</option>
            <option value="closing_important_1_microblogs">Microblogs (Twitter, Tumblr, App.net, Sina Weibo, Plurk, ...)</option>
            <option value="closing_important_1_code_hosting">Code Hosting Sites (GitHub, BitBucket, Launchpad, Google Code, Sourceforge, ...)</option>
            <option value="closing_important_1_project_coord">Project Coordination Tools (Basecamp, Bugtrackers, ...)</option>
            <option value="closing_important_1_qa_sites">Question & Answer Sites (Stack Overflow, Quora, ...)</option>
            <option value="closing_important_1_other">Other</option>
          </select>
          <br>
          <input type="text" placeholder="Why is this channel so important?" name="closing_important_1_why" style="width:95%;"><br>
          <em>2.</em>
          <select name="closing_important_2">
            <option value="closing_important_2_na">Please choose ...</option>
            <option value="closing_important_2_f2f">Face-to-face communication</option>
            <option value="closing_important_2_books">Books and Magazines</option>
            <option value="closing_important_2_search">Web Search (Google, Bing, Duckduckgo, ...)</option>
            <option value="closing_important_2_aggregators">News Aggregators (Hackernews, Reddit, Digg, Slashdot, ...)</option>
            <option value="closing_important_2_feedsblogs">Feeds and Blogs (RSS, Feedly, Newsletters, blogs in general, ...)</option>
            <option value="closing_important_2_recommenders">Content Recommenders (Stumble Upon, Prismatic, Flipboard, ...)</option>
            <option value="closing_important_2_social_bookmarking">Social Bookmarking (Pinterest, Pinboard, Delicious, ...)</option>
            <option value="closing_important_2_rich_content">Rich Content (Podcasts, Screencasts, ...)</option>
            <option value="closing_important_2_discussion_groups">Discussion Groups (Google Groups, Usenet, Forums, ...)</option>
            <option value="closing_important_2_private_discussions">Private Discussions (Email, ...)</option>
            <option value="closing_important_2_public_chat">Public Chat (IRC, ...)</option>
            <option value="closing_important_2_private_chat">Private Chat (IM, Skype Chat, Google Chat, ...)</option>
            <option value="closing_important_2_professional_networking">Professional Networking Sites (LinkedIn, Xing, ...)</option>
            <option value="closing_important_2_dev_profile_sites">Developer Profile Sites (Coderwall, Geekli.st, Masterbranch, ...)</option>
            <option value="closing_important_2_sns">Social Network Sites (Facebook, Google Plus, vk.com, Diaspora, ...)</option>
            <option value="closing_important_2_microblogs">Microblogs (Twitter, Tumblr, App.net, Sina Weibo, Plurk, ...)</option>
            <option value="closing_important_2_code_hosting">Code Hosting Sites (GitHub, BitBucket, Launchpad, Google Code, Sourceforge, ...)</option>
            <option value="closing_important_2_project_coord">Project Coordination Tools (Basecamp, Bugtrackers, ...)</option>
            <option value="closing_important_2_qa_sites">Question & Answer Sites (Stack Overflow, Quora, ...)</option>
            <option value="closing_important_2_other">Other</option>
          </select>
          <br>
          <input type="text" placeholder="Why is this channel so important?" name="closing_important_2_why" style="width:95%;"><br>
          <em>3.</em>
          <select name="closing_important_3">
            <option value="closing_important_3_na">Please choose ...</option>
            <option value="closing_important_3_f2f">Face-to-face communication</option>
            <option value="closing_important_3_books">Books and Magazines</option>
            <option value="closing_important_3_search">Web Search (Google, Bing, Duckduckgo, ...)</option>
            <option value="closing_important_3_aggregators">News Aggregators (Hackernews, Reddit, Digg, Slashdot, ...)</option>
            <option value="closing_important_3_feedsblogs">Feeds and Blogs (RSS, Feedly, Newsletters, blogs in general, ...)</option>
            <option value="closing_important_3_recommenders">Content Recommenders (Stumble Upon, Prismatic, Flipboard, ...)</option>
            <option value="closing_important_3_social_bookmarking">Social Bookmarking (Pinterest, Pinboard, Delicious, ...)</option>
            <option value="closing_important_3_rich_content">Rich Content (Podcasts, Screencasts, ...)</option>
            <option value="closing_important_3_discussion_groups">Discussion Groups (Google Groups, Usenet, Forums, ...)</option>
            <option value="closing_important_3_private_discussions">Private Discussions (Email, ...)</option>
            <option value="closing_important_3_public_chat">Public Chat (IRC, ...)</option>
            <option value="closing_important_3_private_chat">Private Chat (IM, Skype Chat, Google Chat, ...)</option>
            <option value="closing_important_3_professional_networking">Professional Networking Sites (LinkedIn, Xing, ...)</option>
            <option value="closing_important_3_dev_profile_sites">Developer Profile Sites (Coderwall, Geekli.st, Masterbranch, ...)</option>
            <option value="closing_important_3_sns">Social Network Sites (Facebook, Google Plus, vk.com, Diaspora, ...)</option>
            <option value="closing_important_3_microblogs">Microblogs (Twitter, Tumblr, App.net, Sina Weibo, Plurk, ...)</option>
            <option value="closing_important_3_code_hosting">Code Hosting Sites (GitHub, BitBucket, Launchpad, Google Code, Sourceforge, ...)</option>
            <option value="closing_important_3_project_coord">Project Coordination Tools (Basecamp, Bugtrackers, ...)</option>
            <option value="closing_important_3_qa_sites">Question & Answer Sites (Stack Overflow, Quora, ...)</option>
            <option value="closing_important_3_other">Other</option>
          </select>
          <br>
          <input type="text" placeholder="Why is this channel so important?" name="closing_important_3_why" style="width:95%;"><br>
        </div>
      </div>
      <div class="question">
        <div class="question-title">
          Would you like to receive an email when we publish the results of our survey?
        </div>
        <div class="question-comment"></div>
        <div class="question-input">
          <label><input type="checkbox" name="closing_results" value="closing_results_yes"> Yes, please!</label>
        </div>
      </div>
      <div class="question">
        <div class="question-title">
          Would you be up for a short voice interview (Skype, Hangouts, ...) so we can learn more about your response?
        </div>
        <div class="question-comment"></div>
        <div class="question-input">
          <label><input type="checkbox" name="closing_interview" value="closing_interview_yes"> Yes, I'd do that!</label>
        </div>
      </div>
      <div class="question">
        <div class="question-title">
          <label for="closing_results_email">What is your email address?</label>
        </div>
        <div class="question-comment">
          We will only email you if you checked one of the two options above.
        </div>
        <div class="question-input">
          <input type="text" name="closing_results_email" id="closing_results_email">
        </div>
      </div>
      <div class="question">
        <div class="question-title">
          How old are you?
        </div>
        <div class="question-comment"></div>
        <div class="question-input radios">
          <label style="display: inline;"><input type="radio" name="closing_age" value="closing_age_22"> 22 or younger</label>
          <label style="display: inline;"><input type="radio" name="closing_age" value="closing_age_23"> Between 23 and 32 years</label>
          <label style="display: inline;"><input type="radio" name="closing_age" value="closing_age_33"> Between 33 and 45 years</label>
          <label style="display: inline;"><input type="radio" name="closing_age" value="closing_age_46"> Between 46 and 60 years</label>
          <label style="display: inline;"><input type="radio" name="closing_age" value="closing_age_61"> More than 61</label>
        </div>
      </div>
      <div class="question">
        <div class="question-title">
          What is your gender?
        </div>
        <div class="question-comment"></div>
        <div class="question-input radios">
          <label style="display: inline;"><input type="radio" name="closing_gender" value="closing_gender_female"> Female</label>
          <label style="display: inline;"><input type="radio" name="closing_gender" value="closing_gender_male"> Male</label>
          <label style="display: inline;"><input type="radio" name="closing_gender" value="closing_gender_other"> Other</label>
        </div>
      </div>
      <div class="question">
        <div class="question-title">
          <label for="closing_country">Which country do you live in?</label>
        </div>
        <div class="question-comment"></div>
        <div class="question-input">
          <select id="closing_country" name="closing_country">
            <option value="N_A">Choose country</option>
            <option value="AF">Afghanistan</option>
            <option value="AX">Åland Islands</option>
            <option value="AL">Albania</option>
            <option value="DZ">Algeria</option>
            <option value="AS">American Samoa</option>
            <option value="AD">Andorra</option>
            <option value="AO">Angola</option>
            <option value="AI">Anguilla</option>
            <option value="AQ">Antarctica</option>
            <option value="AG">Antigua and Barbuda</option>
            <option value="AR">Argentina</option>
            <option value="AM">Armenia</option>
            <option value="AW">Aruba</option>
            <option value="AU">Australia</option>
            <option value="AT">Austria</option>
            <option value="AZ">Azerbaijan</option>
            <option value="BS">Bahamas</option>
            <option value="BH">Bahrain</option>
            <option value="BD">Bangladesh</option>
            <option value="BB">Barbados</option>
            <option value="BY">Belarus</option>
            <option value="BE">Belgium</option>
            <option value="BZ">Belize</option>
            <option value="BJ">Benin</option>
            <option value="BM">Bermuda</option>
            <option value="BT">Bhutan</option>
            <option value="BO">Bolivia</option>
            <option value="BA">Bosnia and Herzegovina</option>
            <option value="BW">Botswana</option>
            <option value="BV">Bouvet Island</option>
            <option value="BR">Brazil</option>
            <option value="IO">British Indian Ocean Territory</option>
            <option value="BN">Brunei Darussalam</option>
            <option value="BG">Bulgaria</option>
            <option value="BF">Burkina Faso</option>
            <option value="BI">Burundi</option>
            <option value="KH">Cambodia</option>
            <option value="CM">Cameroon</option>
            <option value="CA">Canada</option>
            <option value="CV">Cape Verde</option>
            <option value="KY">Cayman Islands</option>
            <option value="CF">Central African Republic</option>
            <option value="TD">Chad</option>
            <option value="CL">Chile</option>
            <option value="CN">China</option>
            <option value="CX">Christmas Island</option>
            <option value="CC">Cocos (Keeling) Islands</option>
            <option value="CO">Colombia</option>
            <option value="KM">Comoros</option>
            <option value="CG">Congo</option>
            <option value="CD">Congo, The Democratic Republic of The</option>
            <option value="CK">Cook Islands</option>
            <option value="CR">Costa Rica</option>
            <option value="CI">Cote D'ivoire</option>
            <option value="HR">Croatia</option>
            <option value="CU">Cuba</option>
            <option value="CY">Cyprus</option>
            <option value="CZ">Czech Republic</option>
            <option value="DK">Denmark</option>
            <option value="DJ">Djibouti</option>
            <option value="DM">Dominica</option>
            <option value="DO">Dominican Republic</option>
            <option value="EC">Ecuador</option>
            <option value="EG">Egypt</option>
            <option value="SV">El Salvador</option>
            <option value="GQ">Equatorial Guinea</option>
            <option value="ER">Eritrea</option>
            <option value="EE">Estonia</option>
            <option value="ET">Ethiopia</option>
            <option value="FK">Falkland Islands (Malvinas)</option>
            <option value="FO">Faroe Islands</option>
            <option value="FJ">Fiji</option>
            <option value="FI">Finland</option>
            <option value="FR">France</option>
            <option value="GF">French Guiana</option>
            <option value="PF">French Polynesia</option>
            <option value="TF">French Southern Territories</option>
            <option value="GA">Gabon</option>
            <option value="GM">Gambia</option>
            <option value="GE">Georgia</option>
            <option value="DE">Germany</option>
            <option value="GH">Ghana</option>
            <option value="GI">Gibraltar</option>
            <option value="GR">Greece</option>
            <option value="GL">Greenland</option>
            <option value="GD">Grenada</option>
            <option value="GP">Guadeloupe</option>
            <option value="GU">Guam</option>
            <option value="GT">Guatemala</option>
            <option value="GG">Guernsey</option>
            <option value="GN">Guinea</option>
            <option value="GW">Guinea-bissau</option>
            <option value="GY">Guyana</option>
            <option value="HT">Haiti</option>
            <option value="HM">Heard Island and Mcdonald Islands</option>
            <option value="VA">Holy See (Vatican City State)</option>
            <option value="HN">Honduras</option>
            <option value="HK">Hong Kong</option>
            <option value="HU">Hungary</option>
            <option value="IS">Iceland</option>
            <option value="IN">India</option>
            <option value="ID">Indonesia</option>
            <option value="IR">Iran, Islamic Republic of</option>
            <option value="IQ">Iraq</option>
            <option value="IE">Ireland</option>
            <option value="IM">Isle of Man</option>
            <option value="IL">Israel</option>
            <option value="IT">Italy</option>
            <option value="JM">Jamaica</option>
            <option value="JP">Japan</option>
            <option value="JE">Jersey</option>
            <option value="JO">Jordan</option>
            <option value="KZ">Kazakhstan</option>
            <option value="KE">Kenya</option>
            <option value="KI">Kiribati</option>
            <option value="KP">Korea, Democratic People's Republic of</option>
            <option value="KR">Korea, Republic of</option>
            <option value="KW">Kuwait</option>
            <option value="KG">Kyrgyzstan</option>
            <option value="LA">Lao People's Democratic Republic</option>
            <option value="LV">Latvia</option>
            <option value="LB">Lebanon</option>
            <option value="LS">Lesotho</option>
            <option value="LR">Liberia</option>
            <option value="LY">Libyan Arab Jamahiriya</option>
            <option value="LI">Liechtenstein</option>
            <option value="LT">Lithuania</option>
            <option value="LU">Luxembourg</option>
            <option value="MO">Macao</option>
            <option value="MK">Macedonia, The Former Yugoslav Republic of</option>
            <option value="MG">Madagascar</option>
            <option value="MW">Malawi</option>
            <option value="MY">Malaysia</option>
            <option value="MV">Maldives</option>
            <option value="ML">Mali</option>
            <option value="MT">Malta</option>
            <option value="MH">Marshall Islands</option>
            <option value="MQ">Martinique</option>
            <option value="MR">Mauritania</option>
            <option value="MU">Mauritius</option>
            <option value="YT">Mayotte</option>
            <option value="MX">Mexico</option>
            <option value="FM">Micronesia, Federated States of</option>
            <option value="MD">Moldova, Republic of</option>
            <option value="MC">Monaco</option>
            <option value="MN">Mongolia</option>
            <option value="ME">Montenegro</option>
            <option value="MS">Montserrat</option>
            <option value="MA">Morocco</option>
            <option value="MZ">Mozambique</option>
            <option value="MM">Myanmar</option>
            <option value="NA">Namibia</option>
            <option value="NR">Nauru</option>
            <option value="NP">Nepal</option>
            <option value="NL">Netherlands</option>
            <option value="AN">Netherlands Antilles</option>
            <option value="NC">New Caledonia</option>
            <option value="NZ">New Zealand</option>
            <option value="NI">Nicaragua</option>
            <option value="NE">Niger</option>
            <option value="NG">Nigeria</option>
            <option value="NU">Niue</option>
            <option value="NF">Norfolk Island</option>
            <option value="MP">Northern Mariana Islands</option>
            <option value="NO">Norway</option>
            <option value="OM">Oman</option>
            <option value="PK">Pakistan</option>
            <option value="PW">Palau</option>
            <option value="PS">Palestinian Territory, Occupied</option>
            <option value="PA">Panama</option>
            <option value="PG">Papua New Guinea</option>
            <option value="PY">Paraguay</option>
            <option value="PE">Peru</option>
            <option value="PH">Philippines</option>
            <option value="PN">Pitcairn</option>
            <option value="PL">Poland</option>
            <option value="PT">Portugal</option>
            <option value="PR">Puerto Rico</option>
            <option value="QA">Qatar</option>
            <option value="RE">Reunion</option>
            <option value="RO">Romania</option>
            <option value="RU">Russian Federation</option>
            <option value="RW">Rwanda</option>
            <option value="SH">Saint Helena</option>
            <option value="KN">Saint Kitts and Nevis</option>
            <option value="LC">Saint Lucia</option>
            <option value="PM">Saint Pierre and Miquelon</option>
            <option value="VC">Saint Vincent and The Grenadines</option>
            <option value="WS">Samoa</option>
            <option value="SM">San Marino</option>
            <option value="ST">Sao Tome and Principe</option>
            <option value="SA">Saudi Arabia</option>
            <option value="SN">Senegal</option>
            <option value="RS">Serbia</option>
            <option value="SC">Seychelles</option>
            <option value="SL">Sierra Leone</option>
            <option value="SG">Singapore</option>
            <option value="SK">Slovakia</option>
            <option value="SI">Slovenia</option>
            <option value="SB">Solomon Islands</option>
            <option value="SO">Somalia</option>
            <option value="ZA">South Africa</option>
            <option value="GS">South Georgia and The South Sandwich Islands</option>
            <option value="ES">Spain</option>
            <option value="LK">Sri Lanka</option>
            <option value="SD">Sudan</option>
            <option value="SR">Suriname</option>
            <option value="SJ">Svalbard and Jan Mayen</option>
            <option value="SZ">Swaziland</option>
            <option value="SE">Sweden</option>
            <option value="CH">Switzerland</option>
            <option value="SY">Syrian Arab Republic</option>
            <option value="TW">Taiwan, Province of China</option>
            <option value="TJ">Tajikistan</option>
            <option value="TZ">Tanzania, United Republic of</option>
            <option value="TH">Thailand</option>
            <option value="TL">Timor-leste</option>
            <option value="TG">Togo</option>
            <option value="TK">Tokelau</option>
            <option value="TO">Tonga</option>
            <option value="TT">Trinidad and Tobago</option>
            <option value="TN">Tunisia</option>
            <option value="TR">Turkey</option>
            <option value="TM">Turkmenistan</option>
            <option value="TC">Turks and Caicos Islands</option>
            <option value="TV">Tuvalu</option>
            <option value="UG">Uganda</option>
            <option value="UA">Ukraine</option>
            <option value="AE">United Arab Emirates</option>
            <option value="GB">United Kingdom</option>
            <option value="US">United States</option>
            <option value="UM">United States Minor Outlying Islands</option>
            <option value="UY">Uruguay</option>
            <option value="UZ">Uzbekistan</option>
            <option value="VU">Vanuatu</option>
            <option value="VE">Venezuela</option>
            <option value="VN">Viet Nam</option>
            <option value="VG">Virgin Islands, British</option>
            <option value="VI">Virgin Islands, U.S.</option>
            <option value="WF">Wallis and Futuna</option>
            <option value="EH">Western Sahara</option>
            <option value="YE">Yemen</option>
            <option value="ZM">Zambia</option>
            <option value="ZW">Zimbabwe</option>
          </select>
        </div>
      </div>
      <div class="question">
        <div class="question-title">
          <label for="closing_comments">Thanks so much for getting this far! </label>
        </div>
        <div class="question-comment">Any questions, comments or concerns you'd like to tell us about?</div>
        <div class="question-input">
          <textarea name="closing_comments" id="closing_comments"></textarea>
        </div>
      </div>
      <p class="lead" style="text-align:center;">
        <input type="submit" value="Submit Response" class="btn btn-success btn-lg">
      </p>
      <hr/>
      </form>
    </div>
    <script src="js/jquery.min.js"></script>
    <script type="text/javascript">
    var qs = (function(a) {
        if (a == "") return {};
        var b = {};
        for (var i = 0; i < a.length; ++i)
        {
            var p=a[i].split('=');
            if (p.length != 2) continue;
            b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));
        }
        return b;
    })(window.location.search.substr(1).split('&'));
    $(function() {
      if ( qs['ghu'] !== null && qs['ghu'] !== undefined && qs['ghu'].length > 0) {
        // switch github username note
        $("#ghu").val(qs['ghu']);
        $("#ghu-note-delete").show();
        $("#ghu-note-blank").hide();
      }
      $("input.collab_projects").change(function() {
        if ( $(this).val() === "collab_projects_none" ) {
          // hide the smallest / largest questions
          $("#collab_team_smallest_container").hide();
          $("#collab_team_largest_container").hide();
        } else {
          // show the smallest / largest questions
          $("#collab_team_smallest_container").show();
          $("#collab_team_largest_container").show();
        }
      });
    });
    </script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
