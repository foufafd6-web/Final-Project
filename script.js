const siteNameInput =document.getElementById('siteName');
const urlInput =document.getElementById('URL');
const addButton =document.getElementById('addButton');
const bookmarksContainer =document.getElementById('bookmarksContainer');
const emptyMessage =document.getElementById('empty');
const lightDarkButton =document.getElementById('lightDarkMode');
const cardViewButton = document.getElementById('cardView');
const listViewButton = document.getElementById('listView');
const showFavoritesButton =document.getElementById('showFavorites');

let bookmarks =[];

//light/dark mode toggle
// time complexity O(1)

lightDarkButton.addEventListener('click',function()
{
    document.body.classList.toggle('dark-mode');
    //change button text

    if(document.body.classList.contains('dark-mode')){
        lightDarkButton.textContent ='Light mode';
    }
    else{
        lightDarkButton.textContent='Dark mode';
    }
})

//toggle card view

cardViewButton.addEventListener('click',function()
{
    bookmarksContainer.classList.add('card-view');
    bookmarksContainer.classList.remove('list-view');
});

//toggle list view

listViewButton.addEventListener('click',function(){
    bookmarksContainer.classList.add('list-view');
    bookmarksContainer.classList.remove('card-view');
});

addButton.addEventListener('click',function() {
     //get the name and the url

    const title =siteNameInput.value.trim();
    const url = urlInput.value.trim();

     //valid or invalid inputs

    if(title=== ''){ 
        alert('Enter a Website name');
        return;
    }
    if(!url.startsWith('http://')&& !url.startsWith('https://')){
       alert('URL must start with http:// or https://');
       return;
    }

    const bookmark = {
        title:title,
        url:url,
        favorite:false
    };

    //add to the array
    // time complexity O(1)

    bookmarks.push(bookmark);

    //render bookmarks on the page

    renderBookmarks();
    siteNameInput.value ='';
    urlInput.value = '';
});

//toggle show favorites

let showingFavorites = false;
showFavoritesButton.addEventListener('click',function() {
     showingFavorites = !showingFavorites;
     showFavoritesButton.textContent =showingFavorites ? "show all" : "show favorites" ;
     renderBookmarks();
 });
     

//dom manipulation

function renderBookmarks(){

    //clear previous bookmarks
    // time comlexity O(1)

    bookmarksContainer.innerHTML ='';
    const bookmarksToShow = showingFavorites
         ? bookmarks.filter(bm => bm.favorite)
         : bookmarks;

    //filter showing fav

    if(bookmarksToShow.length ===0){
        emptyMessage.style.display= 'block';
        return;
    }
    else{
        emptyMessage.style.display ='none';
    }
    //create bookmark elements

    bookmarksToShow.forEach((bm,index) => {
        const div =document.createElement('div');
        div.className ='bookmark';

        //bookmark url link

        const link =document.createElement('a');
        link.href =bm.url;
        link.textContent=bm.title;
        link.target ='_blank';
        div.appendChild(link);

        //favorite button

        const favoriteButton =document.createElement('button');
        favoriteButton.textContent=bm.favorite?'★' : '☆';
        favoriteButton.addEventListener('click',function(){
            bm.favorite=!bm.favorite;
            // time complexity O(n)

            renderBookmarks();//rerender to update star
        });
        div.appendChild(favoriteButton);

        //delete button

        const deleteButton =document.createElement('button');
        deleteButton.textContent = '🗑';
        // time complexity O(n)

        deleteButton.addEventListener('click',function(){
            bookmarks.splice(index,1);
            renderBookmarks();
        });
        div.appendChild(deleteButton);

        bookmarksContainer.appendChild(div);
    });
}
