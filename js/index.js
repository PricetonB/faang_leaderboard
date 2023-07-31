let floating_form = document.getElementById("floating_form");
let new_mem_btn = document.getElementById("new_mem_btn");

new_mem_btn.addEventListener("click", function(){
  if(floating_form.style.left == "-100%"){
    floating_form.style.left = "15px";
  }else if(floating_form.style.left == "15px"){
    floating_form.style.left = "-100%"
  }else{
    floating_form.style.left = "15px";
  }
})


const unixToDate = function (unixTimestamp) {
  const date = new Date(unixTimestamp * 1000);
  const year = date.getFullYear();
  const month = date.getMonth() + 1;
  const day = date.getDate();
  const formattedDate = `${year}-${month.toString().padStart(2, "0")}-${day
    .toString()
    .padStart(2, "0")}`;
  return formattedDate;
};

function simplify(inputObject) {
  const submissions = Object.entries(inputObject).map(([key, value]) => [
    parseInt(key),
    value,
  ]);
  let sub_2 = [];
  for (let i = 0; i < submissions.length; i++) {
    let temp = [];
    temp.push(unixToDate(submissions[i][0]));
    temp.push(submissions[i][1]);
    sub_2.push(temp);
  }
  let flat_sub_2 = sub_2.flat();
  let finalArr = [];
  let today = new Date();
  const oneDayInMilliseconds = 24 * 60 * 60 * 1000;
  for (let i = 0; i < 30; i++) {
    const year = today.getFullYear();
    const month = today.getMonth() + 1;
    const day = today.getDate();
    const formattedDate = `${year}-${month.toString().padStart(2, "0")}-${day
      .toString()
      .padStart(2, "0")}`;
    if (flat_sub_2.includes(formattedDate)) {
      finalArr.unshift(flat_sub_2[flat_sub_2.indexOf(formattedDate) + 1]);
    } else {
      finalArr.unshift("0");
    }
    today = new Date(today.getTime() - oneDayInMilliseconds);
  }
  return finalArr;
}

let submissions;
let rank;
let easy;
let medium;
let hard;
let total;
let lcname;
let discname;

function postRequest(){
  lcname = document.getElementById("lc_name_inp").value.toLowerCase();
  discname = document.getElementById("disc_name_inp").value;
  $.ajax({
    type: "GET",
    url: `https://faisal-leetcode-api.cyclic.app/${lcname}`,
    cache: false,
    success: function (data) {
      console.log(data);
      submissions = simplify(data.submissionCalendar);
      rank = data.ranking;
      easy = data.easySolved;
      medium = data.mediumSolved;
      hard = data.hardSolved;
      total = data.totalSolved;
      // console.log([
      //   ["submissions", submissions],
      //   ["rank", rank],
      //   ["easy", easy],
      //   ["medium", medium],
      //   ["hard", hard],
      //   ["total", total],
      //   ["lcname", lcname],
      //   ["discname", discname]
      // ])
      $.ajax(
        {
           type: 'post',
           url: 'https://faang.yash.lol/php/new.php',
           data: { 
             "discord_name": discname,
             "lc_name": lcname,
             "lc_rank": rank,
             "easy" : easy,
             "medium": medium,
             "hard" : hard,
             "total" : total,
             "heatmap" : submissions.join(",")
           },
           success: function (response) {
             alert("Success !!");
             location.reload();
           },
           error: function () {
             alert("Error !!");
           }
        }
     );
    },
  });
}
