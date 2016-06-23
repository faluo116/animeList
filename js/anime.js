function checkForm(){
	var id = $("#id").val();
	var a_title = $("#a_title").val();
	if (a_title.length == 0){
		alert("标题必须输入");
		return false;
	}
	var a_week = $("#a_week").val();
	var a_count = $("#a_count").val();
	if (!isNum(a_count)){
		alert("集数必须为数字");
		return false;
	}
	var a_housou = $("#a_housou").val();
	var a_yandere = $("#a_yandere").val();
	var a_first = $("#a_first").val();
	if (!isNum(a_first)){
		alert("首播日必须为数字");
		return false;
	}
	var a_step = $("#a_step").val();
	if (!isNum(a_step)){
		alert("步长必须为数字");
		return false;
	}
	var a_content = $("#a_content").val();
	var a_cover_img = $("#a_cover_img").val();

	var form = document.createElement("form");
	document.body.appendChild(form);
	
	var txt_title = document.createElement("input");
	txt_title.type = "text";
	txt_title.name = "a_title";
	txt_title.value = a_title;
	form.appendChild(txt_title);
	var txt_week = document.createElement("input");
	txt_week.type = "text";
	txt_week.name = "a_week";
	txt_week.value = a_week;
	form.appendChild(txt_week);
	var txt_count = document.createElement("input");
	txt_count.type = "text";
	txt_count.name = "a_count";
	txt_count.value = a_count;
	form.appendChild(txt_count);
	var txt_housou = document.createElement("input");
	txt_housou.type = "text";
	txt_housou.name = "a_housou";
	txt_housou.value = a_housou;
	form.appendChild(txt_housou);
	var txt_yandere = document.createElement("input");
	txt_yandere.type = "text";
	txt_yandere.name = "a_yandere";
	txt_yandere.value = a_yandere;
	form.appendChild(txt_yandere);
	var txt_first = document.createElement("input");
	txt_first.type = "text";
	txt_first.name = "a_first";
	txt_first.value = a_first;
	form.appendChild(txt_first);
	var txt_step = document.createElement("input");
	txt_step.type = "text";
	txt_step.name = "a_step";
	txt_step.value = a_step;
	form.appendChild(txt_step);
	var txt_content = document.createElement("input");
	txt_content.type = "text";
	txt_content.name = "a_content";
	txt_content.value = a_content;
	form.appendChild(txt_content);
	var txt_cover_img = document.createElement("input");
	txt_cover_img.type = "text";
	txt_cover_img.name = "a_cover_img";
	txt_cover_img.value = a_cover_img;
	form.appendChild(txt_cover_img);

	form.name="modify_anime";
	form.method="post";
	form.action="modify.php?id=" + id + "&up=1"
	form.submit();
}

function newAnime(){
	var id = $("#id").val();
	var a_title = $("#a_title").val();
	if (a_title.length == 0){
		alert("标题必须输入");
		return false;
	}
	var a_week = $("#a_week").val();
	var a_count = $("#a_count").val();
	if (!isNum(a_count)){
		alert("集数必须为数字");
		return false;
	}
	var a_housou = $("#a_housou").val();
	var a_yandere = $("#a_yandere").val();
	var a_first = $("#a_first").val();
	if (!isNum(a_first)){
		alert("首播日必须为数字");
		return false;
	}
	var a_step = $("#a_step").val();
	if (!isNum(a_step)){
		alert("步长必须为数字");
		return false;
	}
	var a_content = $("#a_content").val();
	var a_cover_img = $("#a_cover_img").val();

	var form = document.createElement("form");
	document.body.appendChild(form);
	
	var txt_title = document.createElement("input");
	txt_title.type = "text";
	txt_title.name = "a_title";
	txt_title.value = a_title;
	form.appendChild(txt_title);
	var txt_week = document.createElement("input");
	txt_week.type = "text";
	txt_week.name = "a_week";
	txt_week.value = a_week;
	form.appendChild(txt_week);
	var txt_count = document.createElement("input");
	txt_count.type = "text";
	txt_count.name = "a_count";
	txt_count.value = a_count;
	form.appendChild(txt_count);
	var txt_housou = document.createElement("input");
	txt_housou.type = "text";
	txt_housou.name = "a_housou";
	txt_housou.value = a_housou;
	form.appendChild(txt_housou);
	var txt_yandere = document.createElement("input");
	txt_yandere.type = "text";
	txt_yandere.name = "a_yandere";
	txt_yandere.value = a_yandere;
	form.appendChild(txt_yandere);
	var txt_first = document.createElement("input");
	txt_first.type = "text";
	txt_first.name = "a_first";
	txt_first.value = a_first;
	form.appendChild(txt_first);
	var txt_step = document.createElement("input");
	txt_step.type = "text";
	txt_step.name = "a_step";
	txt_step.value = a_step;
	form.appendChild(txt_step);
	var txt_content = document.createElement("input");
	txt_content.type = "text";
	txt_content.name = "a_content";
	txt_content.value = a_content;
	form.appendChild(txt_content);
	var txt_cover_img = document.createElement("input");
	txt_cover_img.type = "text";
	txt_cover_img.name = "a_cover_img";
	txt_cover_img.value = a_cover_img;
	form.appendChild(txt_cover_img);

	form.name="modify_anime";
	form.method="post";
	form.action="add.php?up=1"
	form.submit();
}

function isNum(d){
	var re = new RegExp("^[0-9]*$");
	return re.test(d);
}