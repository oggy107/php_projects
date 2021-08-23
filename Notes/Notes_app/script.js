const editBtns = Array.from(document.getElementsByClassName("edit-btn"));
const delBtns = Array.from(document.getElementsByClassName("del-btn"));

const addDataToEditModal = (titleData, descData, snoData) => {
  const noteTitleEdit = document.getElementById("note_title_edit");
  const noteDescEdit = document.getElementById("note_desc_edit");
  const noteSnoEdit = document.getElementById("note_sno_edit");

  noteTitleEdit.value = titleData;
  noteDescEdit.value = descData;
  noteSnoEdit.value = snoData;
};

editBtns.forEach((editBtn) => {
  editBtn.addEventListener("click", (e) => {
    const target = e.target;
    const tr = target.parentNode.parentNode;
    const target_title = tr.childNodes[2].innerHTML;
    const target_desc = tr.childNodes[3].innerHTML;
    const target_sno = target.id;
    console.log("edit title: ", target_title);
    console.log("edit desc: ", target_desc);
    console.log("edit sno: ", target_sno);

    addDataToEditModal(target_title, target_desc, target_sno);
  });
});

delBtns.forEach((delBtn) => {
  delBtn.addEventListener("click", (e) => {
    const target_sno = e.target.id.substr(1);
    console.log("del sno: ", target_sno);
    if (confirm("Are you sure you want to delete this note?")) {
      window.location = `./?del=${target_sno}`;
    }
  });
});

const delAllBtn = document.querySelector(".del-all-btn");
delAllBtn.addEventListener("click", () => {
  if (confirm("Are you sure you want to delete all your notes?")) {
    window.location = "./?del-all=true";
  }
});

const delAccBtn = document.querySelector('.del-acc-btn');
delAccBtn.addEventListener("click", () => {
  if (confirm("Are you sure you want to delete your account?"))
    window.location = "./?del-acc=true";
})
