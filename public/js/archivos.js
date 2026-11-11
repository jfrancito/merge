
    var carpeta = $("#carpeta").val();
	
	// no react or anything
	let state = {};

	// state management
	function updateState(newState) {
		debugger;
		state = { ...state, ...newState };
		console.log(state);
	}


    $(".tab-container").on('change','#upload', function() {
		debugger;
		let files = document.getElementById("upload").files;
		console.log(files);
		let filesArr = Array.from(files);
		updateState({ files: files, filesArr: filesArr });

		renderFileList();
	});


	$("#uploadapafa").change(function(e) {
		debugger;
		let files = document.getElementById("uploadapafa").files;
		console.log(files);
		let filesArr = Array.from(files);
		updateState({ files: files, filesArr: filesArr });

		renderFileListapafa();
	});

	$("#upload03").change(function(e) {
		debugger;
		let files = document.getElementById("upload03").files;
		console.log(files);
		let filesArr = Array.from(files);
		updateState({ files: files, filesArr: filesArr });

		renderFileList03();
	});

	$("#upload04").change(function(e) {
		debugger;
		let files = document.getElementById("upload04").files;
		console.log(files);
		let filesArr = Array.from(files);
		updateState({ files: files, filesArr: filesArr });

		renderFileList04();
	});

	$("#upload05").change(function(e) {
		debugger;
		let files = document.getElementById("upload05").files;
		console.log(files);
		let filesArr = Array.from(files);
		updateState({ files: files, filesArr: filesArr });

		renderFileList05();
	});





	$(".files").on("click", "li > i", function(e) {
		debugger;
		let key = $(this)
			.parent()
			.attr("key");
		let curArr = state.filesArr;
		curArr.splice(key, 1);
		state = {};

		updateState({ filesArr: curArr });

		renderFileList();
	});


	$(".filesapafa").on("click", "li > i", function(e) {
		debugger;
		let key = $(this)
			.parent()
			.attr("key");
		let curArr = state.filesArr;
		curArr.splice(key, 1);
		updateState({ filesArr: curArr });
		renderFileListapafa();
	});

	$(".files03").on("click", "li > i", function(e) {
		debugger;
		let key = $(this)
			.parent()
			.attr("key");
		let curArr = state.filesArr;
		curArr.splice(key, 1);
		updateState({ filesArr: curArr });
		renderFileList03();
	});

	$(".files04").on("click", "li > i", function(e) {
		debugger;
		let key = $(this)
			.parent()
			.attr("key");
		let curArr = state.filesArr;
		curArr.splice(key, 1);
		updateState({ filesArr: curArr });
		renderFileList04();
	});


	$(".files05").on("click", "li > i", function(e) {
		debugger;
		let key = $(this)
			.parent()
			.attr("key");
		let curArr = state.filesArr;
		curArr.splice(key, 1);
		updateState({ filesArr: curArr });
		renderFileList05();
	});


	// render functions
	function renderFileList() {
		debugger;
		let fileMap = state.filesArr.map((file, index) => {
			let suffix = "bytes";
			let size = file.size;
			if (size >= 1024 && size < 1024000) {
				suffix = "KB";
				size = Math.round(size / 1024 * 100) / 100;
			} else if (size >= 1024000) {
				suffix = "MB";
				size = Math.round(size / 1024000 * 100) / 100;
			}

			return `<li key="${index}"><span class='nombre_file'>${
				file.name
			}</span> <span class="file-size">${size} ${suffix}</span></li>`;


		});
		$("#larchivos").html(fileMap);
	}

	// render functions
	function renderFileListapafa() {
		let fileMap = state.filesArr.map((file, index) => {
			let suffix = "bytes";
			let size = file.size;
			if (size >= 1024 && size < 1024000) {
				suffix = "KB";
				size = Math.round(size / 1024 * 100) / 100;
			} else if (size >= 1024000) {
				suffix = "MB";
				size = Math.round(size / 1024000 * 100) / 100;
			}

			return `<li key="${index}"><span class='nombre_file'>${
				file.name
			}</span> <span class="file-size">${size} ${suffix}</span></li>`;


		});
		$("#larchivosapafa").html(fileMap);
	}

	// render functions
	function renderFileList03() {
		debugger
		let fileMap = state.filesArr.map((file, index) => {
			let suffix = "bytes";
			let size = file.size;
			if (size >= 1024 && size < 1024000) {
				suffix = "KB";
				size = Math.round(size / 1024 * 100) / 100;
			} else if (size >= 1024000) {
				suffix = "MB";
				size = Math.round(size / 1024000 * 100) / 100;
			}

			return `<li key="${index}"><span class='nombre_file'>${
				file.name
			}</span> <span class="file-size">${size} ${suffix}</span></li>`;


		});
		$("#larchivos03").html(fileMap);
	}

	// render functions
	function renderFileList04() {
		let fileMap = state.filesArr.map((file, index) => {
			let suffix = "bytes";
			let size = file.size;
			if (size >= 1024 && size < 1024000) {
				suffix = "KB";
				size = Math.round(size / 1024 * 100) / 100;
			} else if (size >= 1024000) {
				suffix = "MB";
				size = Math.round(size / 1024000 * 100) / 100;
			}

			return `<li key="${index}"><span class='nombre_file'>${
				file.name
			}</span> <span class="file-size">${size} ${suffix}</span></li>`;


		});
		$("#larchivos04").html(fileMap);
	}

 		// render functions
	function renderFileList05() {
		let fileMap = state.filesArr.map((file, index) => {
			let suffix = "bytes";
			let size = file.size;
			if (size >= 1024 && size < 1024000) {
				suffix = "KB";
				size = Math.round(size / 1024 * 100) / 100;
			} else if (size >= 1024000) {
				suffix = "MB";
				size = Math.round(size / 1024000 * 100) / 100;
			}

			return `<li key="${index}"><span class='nombre_file'>${
				file.name
			}</span> <span class="file-size">${size} ${suffix}</span></li>`;


		});
		$("#larchivos05").html(fileMap);
	}





