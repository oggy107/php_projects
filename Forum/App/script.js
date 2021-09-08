// FOR OPENING A THREAD
const openThreadBtns = Array.from(document.getElementsByClassName('btn-open-category'));

openThreadBtns.forEach((btn) => {
    btn.addEventListener('click', (e) => {
        console.log(e.target);

        const categoryId = e.target.dataset.id;

        console.log(document.location);
        document.location = `./thread_list.php/?categoryId=${categoryId}`;
    })
})

// FOR VIEWING A THREAD

const viewThreadBtn = Array.from(document.getElementsByClassName('btn-view-thread'));

viewThreadBtn.forEach((btn) => {
    btn.addEventListener('click', (e) => {
        const threadId = e.target.dataset.id;

        document.location = `../thread.php/?threadId=${threadId}`;
    })
})