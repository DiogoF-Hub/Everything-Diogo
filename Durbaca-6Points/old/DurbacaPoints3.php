<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Points</title>

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');

    .error {
      color: #FF0000;
    }

    .red {
      background-color: red;
    }

    .yellow {
      background-color: yellow;
    }

    .green {
      background-color: green;
    }

    .yellowText {
      color: yellow;
    }

    body {
      text-align: center;
      background: #fff;
      max-width: 60ch;
      margin: 10px auto;
      padding: 15px;
      border-radius: 5px;
      box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.1);

    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    textarea {
      border-radius: 5px;
      border-color: #3399ff;
    }

    body input {
      width: 25%;
      border-radius: 5px;
      margin: 10px 0;
      border-color: #9999ff;
      opacity: 1.7;

    }

    h1 {
      color: #cce6ff;
      background-color: #004d99;
      padding: 10px;
      border-color: #3399ff;
      font-size: 40px;
      -webkit-text-stroke: 1px #282828;
      text-shadow: 0px 4px 4px #282828;
      border-radius: 3px;
    }

    .right_side {
      font-size: 20px;
    }

    .center_stuff {
      width: 5ch;
    }
  </style>


  <?php

  $arrayOfStudents = ["Parraga Melanie", "Carvalho Diogo", "Shafiq Hassam", "Oliveira Rui", "Mendes Milton", "Markulin Filip", "Miniatis Fanourios", "Dos Santos Rúben", "Murtadha Mustafa", "Nonkovic Filip", "Kushniryna Vladyslav", "Gloden Jeff", "Cazar Dominick", "Linster Francesco", "Li Shaopeng"];
  sort($arrayOfStudents);

  print('<script> 
  arrayOfStudents = ["Parraga Melanie", "Carvalho Diogo", "Shafiq Hassam", "Oliveira Rui", "Mendes Milton", "Markulin Filip", "Miniatis Fanourios", "Dos Santos Rúben", "Murtadha Mustafa", "Nonkovic Filip", "Kushniryna Vladyslav", "Gloden Jeff", "Cazar Dominick", "Linster Francesco", "Li Shaopeng"];
  arrayOfStudents.sort();
  arrayOfStudentsDone = [];
  </script>');

  include_once("CheckStudent.php");


  $StudentName = "";
  $StudentNameErr = "";

  $Marks = "";
  $MarksErr = "";

  $Cookie = "";
  $CookieErr = "";
  $CookieOptionsArr = ["Normal Cookie", "Twix", "Mars", "Kit-Kat", "Oreo", "Snickers", "M&M's"];

  $Comment = "";
  $CommentErr = "";

  $Task = "";
  $TaskErr = "";


  //this one i found on internet and i understand most of the things
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_POST["studentname"] == "-1") {
      //$StudentNameErr = "* Student Name is required";
      die();
    } else {
      if (in_array($_POST["studentname"], $arrayOfStudents)) {
        $StudentName = $_POST["studentname"];
      } else {
        //$StudentNameErr = "* Student Name is required";
        die();
      }
    }


    if ($_POST["points"] >= 0 && $_POST["points"] <= 6) {
      $Marks = $_POST["points"];
    } else {
      //$MarksErr = "* Points must be from 0 to 6";
      die();
    }


    if (!empty($_POST["cookieInput"])) { // not empty means selected,  bcs when its not selected its = to nothing
      if ($_POST["SelectCookieName"] == -1) {
        //$CookieErr = "* Cookie type is required";
        die();
      } else {
        if (in_array($_POST["SelectCookieName"], $CookieOptionsArr)) {
          $Cookie = $_POST["SelectCookieName"];
        } else {
          //$CookieErr = "* Cookie type is required";
          die();
        }
      }
    } else {
      $Cookie = "/"; //if its not selected means no cookies as its written on the comment on top
    }


    if ($_POST["task"] == "http://192.168./**.*:port/") {
      //$TaskErr = "* Task is required";
      die();
    } else {
      if (strlen($_POST["task"]) <= 100) {
        $Task = $_POST["task"];
      } else {
        //$TaskErr = "* Task is required";
        die();
      }
    }



    if (strlen($Comment = $_POST["comment"]) <= 100) {
      if ($Marks < 6 && empty($Comment)) {
        //$CommentErr = "* Comment its mandatory when its less than 6p";
        die();
      }
    } else {
      //$CommentErr = "* Comment its mandatory when its less than 6p";
      die();
    }


    /*if (!empty($StudentNameErr) or !empty($TaskErr) or !empty($CommentErr) or !empty($CookieErr)) {
    echo 'Not saved :(';
    } else {*/
    if (empty($Comment)) {
      $Comment = "/";
    }
    $text = "Name: " . $StudentName . "\n" . "Points: " . $Marks . "\n" . "Cookie: " . $Cookie . "\n" . "Comment: " . $Comment . "\n" . "\n" . "Task: " . "\n" . $Task . "\n" . "--------------" . "\n";
    $fp = fopen('..\testfolder\points.txt', 'a+');

    if (fwrite($fp, $text)) {
      echo 'saved :)';
    }

    fclose($fp);
    /*}*/
    //include_once("CheckStudent.php");
  }


  ?>


  <script>
    /*for (let i = 0; i < arrayOfStudents.length; i++) {
      if()
      arrayOfStudents.splice(i, 1);
    }*/


    MyCookieOption = document.createElement("option");
    MyCookieOption.value = "-1";
    MyCookieOption.text = "Select Cookie";
    MyCookieOption.setAttribute("hidden", "hidden");
    MyCookieOption.setAttribute("selected", "selected");

    MypeppaImg = document.createElement("img");
    MypeppaImg.alt = "peppaCookie";
    MypeppaImg.width = "220";
    MypeppaImg.height = "90";

    function putimg() {
      myimg = document.getElementById("SelectCookieId").value;
      document.getElementById("peppaImgDiv").innerHTML = "";
      if (CookieOptionsArr.indexOf(myimg) !== -1) {
        MypeppaImg.src = CookieOptionsArrImgs[myimg];
        document.getElementById("peppaImgDiv").append(MypeppaImg);
      } else {
        document.getElementById("peppaImgDiv").innerHTML = "Nice Try";
      }
    }

    CookieOptionsArr = ["Normal Cookie", "Twix", "Mars", "Kit-Kat", "Oreo", "Snickers", "M&M's"];
    CookieOptionsArrImgs = {
      "Normal Cookie": "https://i.ytimg.com/vi/N7EHjdV0vlE/maxresdefault.jpg",
      "Twix": "https://imgix.lifehacker.com.au/content/uploads/sites/4/2018/04/TWIX.jpg?ar=16%3A9&auto=format&fit=crop&q=80&w=1280&nr=20",
      "Mars": "https://www.cityam.com/wp-content/uploads/2019/05/mars-announces-world-wide-recall-of-chocolate-bars-511842510-56d68290d0353-1280x720.jpg",
      "Kit-Kat": "https://imagesvc.meredithcorp.io/v3/jumpstartpure/image?url=https://cf-images.us-east-1.prod.boltdns.net/v1/static/1660653193/f37127eb-21fa-4553-b937-fdd9e70628d6/31d42266-ebfd-4899-b983-38030b99c692/1280x720/match/image.jpg&w=1280&h=720&q=90&c=cc",
      "Oreo": "https://www.wivb.com/wp-content/uploads/sites/97/2019/05/1280x720_31016C00-GOVVF_1556813722573_85656007_ver1.0.jpg?w=1280",
      "Snickers": "https://www.dontwasteyourmoney.com/wp-content/uploads/2020/04/snickers-adobe-scaled-e1587746530571-1280x720.jpeg",
      "M&M's": "https://bilder.bild.de/fotos/m-und-ms-crispy-rueckrufaktion-wegen-genmanipulierter-inhalte-59ca211123ae40fdb88d2786dcb9bb76-77289328/Bild/4.bild.jpg"
    };
    //CookieOptionsArrImgs = ["https://i.ytimg.com/vi/N7EHjdV0vlE/maxresdefault.jpg", "https://imgix.lifehacker.com.au/content/uploads/sites/4/2018/04/TWIX.jpg?ar=16%3A9&auto=format&fit=crop&q=80&w=1280&nr=20", "https://www.cityam.com/wp-content/uploads/2019/05/mars-announces-world-wide-recall-of-chocolate-bars-511842510-56d68290d0353-1280x720.jpg", "https://imagesvc.meredithcorp.io/v3/jumpstartpure/image?url=https://cf-images.us-east-1.prod.boltdns.net/v1/static/1660653193/f37127eb-21fa-4553-b937-fdd9e70628d6/31d42266-ebfd-4899-b983-38030b99c692/1280x720/match/image.jpg&w=1280&h=720&q=90&c=cc", "https://www.wivb.com/wp-content/uploads/sites/97/2019/05/1280x720_31016C00-GOVVF_1556813722573_85656007_ver1.0.jpg?w=1280", "https://www.dontwasteyourmoney.com/wp-content/uploads/2020/04/snickers-adobe-scaled-e1587746530571-1280x720.jpeg", "https://bilder.bild.de/fotos/m-und-ms-crispy-rueckrufaktion-wegen-genmanipulierter-inhalte-59ca211123ae40fdb88d2786dcb9bb76-77289328/Bild/4.bild.jpg"];


    function loadthis() {
      /*for (let i = 0; i < arrayOfStudents.length; i++) {
        let Myoption = document.createElement("option");
        Myoption.value = arrayOfStudents[i];
        Myoption.text = arrayOfStudents[i];
        Myoption.id = arrayOfStudents[i];
        document.getElementById("StudentSelect").append(Myoption);
      }*/

      inputValues = document.getElementById("InputPoints").value;
      document.getElementById("NumberId").innerHTML = inputValues + "/6";
      pointsNumber(inputValues);

    }

    function pointsNumber(value) {
      document.getElementById("NumberId").innerHTML = value + "/6";
      if (value != 6) {
        document.getElementById("peppaImgDiv").innerHTML = "";
        document.getElementById("hidden").innerHTML = "";
        document.getElementById("hidden2").innerHTML = "";
      }
      if (value <= 2) {
        document.getElementById("NumberId").className = "red";
      } else {
        if (value <= 4) {
          document.getElementById("NumberId").className = "yellow";
        } else {
          document.getElementById("NumberId").className = "green";
          if (value == 6) {
            document.getElementById("NumberId").className = "green yellowText";

            document.getElementById("hidden").innerHTML = 'Cookie:<input id="checkId" class="center_stuff" type="checkbox" value="yes" name="cookieInput" onchange="changePeppa(this);">';
          }
        }
      }
    }

    function changePeppa(checkbox) {
      if (checkbox.checked == false) {
        document.getElementById("hidden2").innerHTML = "";
        document.getElementById("peppaImgDiv").innerHTML = "";
      } else {
        document.getElementById("hidden2").innerHTML = '<select name="SelectCookieName" id="SelectCookieId" onchange="putimg();"></select>';

        document.getElementById("SelectCookieId").append(MyCookieOption);

        for (let i = 0; i < CookieOptionsArr.length; i++) {
          let Myoption2 = document.createElement("option");
          Myoption2.text = CookieOptionsArr[i];
          Myoption2.value = CookieOptionsArr[i];
          Myoption2.id = CookieOptionsArr[i];
          document.getElementById("SelectCookieId").append(Myoption2);
        }

        document.getElementById("Kit-Kat").setAttribute("disabled", "disabled");
        document.getElementById("Kit-Kat").innerHTML += " (sold out)";
      }
    }

    function checkForm() {
      StudentValue = document.getElementById("StudentSelect").value;
      StudentCheck = "";

      PointsValue = document.getElementById("InputPoints").value;
      PointsCheck = "";

      if (StudentValue != "-1") {
        if (arrayOfStudentsDone.indexOf(StudentValue) !== -1) {
          StudentCheck = 1;
        } else {
          StudentCheck = 0;
        }
      } else {
        StudentCheck = 1;
      }


      if (PointsValue >= 0 && PointsValue <= 6) {
        PointsCheck = 0;
      } else {
        PointsCheck = 1;
      }

      if (PointsValue == 6) {
        if (document.getElementById("checkId").checked == true) {
          SelectCookieValue = document.getElementById("SelectCookieId").value;
          if (SelectCookieId != -1) {
            if (CookieOptionsArr.indexOf(SelectCookieValue) !== -1) {
              CookieCheck = 0;
            } else {
              CookieCheck = 1;
            }
          } else {
            CookieCheck = 1;
          }
        } else {
          CookieCheck = 0; //notgiven
        }
      } else {
        CookieCheck = 0; //notgiven
      }


      TaskValue = document.getElementById("taskId").value;
      TaskCheck = "";

      CommentValue = document.getElementById("commentId").value;
      CommentCheck = "";



      if (TaskValue.length <= 100) {
        if (TaskValue != "http://192.168./**.*:port/") {
          TaskCheck = 0;
        } else {
          TaskCheck = 1;
        }
      } else {
        TaskCheck = 1;
      }


      if (CommentValue.length > 100) {
        CommentCheck = 1;
      } else {
        if (PointsValue < 6 && CommentValue == '') {
          CommentCheck = 1;
        } else {
          CommentCheck = 0; //notNeeded
        }
      }

      //alert("Student: " + StudentCheck + "\n" + "Points: " + PointsCheck + "\n" + "Cookie: " + CookieCheck + "\n" + "Task: " + TaskCheck + "\n" + "Comment: " + CommentCheck);

      if (StudentCheck + PointsCheck + CookieCheck + TaskCheck + CommentCheck == 0) {
        document.getElementById("myForm").submit();
        document.getElementById("myForm").reset();

      } else {
        if (StudentCheck == 1) {
          document.getElementById("spanStudentErr").innerHTML = "* Student Name is required";
        } else {
          document.getElementById("spanStudentErr").innerHTML = "";
        }

        if (PointsCheck == 1) {
          document.getElementById("spanPointsErr").innerHTML = "* Select the points";
        } else {
          document.getElementById("spanPointsErr").innerHTML = "";
        }

        if (CookieCheck == 1) {
          document.getElementById("spanCookieErr").innerHTML = "* Cookie type is required";
        } else {
          document.getElementById("spanCookieErr").innerHTML = "";
        }

        if (TaskCheck == 1) {
          document.getElementById("spanTaskErr").innerHTML = "* Task is required";
        } else {
          document.getElementById("spanTaskErr").innerHTML = "";
        }

        if (CommentCheck == 1) {
          document.getElementById("spanCommentErr").innerHTML = "* Comment its mandatory when its less than 6p";
        } else {
          document.getElementById("spanCommentErr").innerHTML = "";
        }

      }

    }
  </script>

</head>


<body onload="loadthis();">
  <form id="myForm" method="post">
    <h1>6 Points for compétences 2TPIFI</h1>

    <div class="right_side">Student Name:</div>
    <select name="studentname" id="StudentSelect">
      <option hidden value="-1">Select Student</option>
      <?php
      for ($i = 0; $i < count($arrayOfStudents); $i++) {
      ?>
        <option id="<?= $arrayOfStudents[$i] ?>" value="<?= $arrayOfStudents[$i] ?>"><?= $arrayOfStudents[$i] ?></option>
      <?php
      }
      ?>
    </select>
    <br>
    <span id="spanStudentErr" class="error"></span>
    <br><br>

    <div class="right_side">Points:</div>
    <input id="InputPoints" name="points" type="range" min="0" max="6" value="0" onchange="pointsNumber(value);">
    <span class="red" id="NumberId"></span>
    <br>
    <span id="spanPointsErr" class="error"></span>

    <div class="right_side" id="hidden"></div>
    <span class="error"></span>
    <div class="right_side" id="hidden2"></div>
    <span id="spanCookieErr" class="error"></span>
    <br><br>


    <div class="right_side">Task:</div>
    <textarea maxlength="100" id="taskId" name="task" rows="5" cols="45">http://192.168./**.*:port/</textarea>
    <br>
    <span id="spanTaskErr" class="error"></span>
    <br><br>

    <div class="right_side">Comment:</div>
    <textarea maxlength="100" id="commentId" name="comment" rows="5" cols="45"></textarea>
    <br>
    <span id="spanCommentErr" class="error"></span>

    <!--<input type="submit" name="submit_btn" id="submit" value="Submit">-->
  </form>
  <button onclick="checkForm();">Submit</button>

  <div id="peppaImgDiv"></div>
</body>

</html>