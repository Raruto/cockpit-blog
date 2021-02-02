@extend('layouts:base.php')

<div class="search-ui">
  <input type="text" id="search-str" class="m-auto w-100" placeholder="search" />
</div>
<div class="search-results"></div>
<script>
  var searchIndex    = null;
  var searchUI       = document.querySelector('.search-ui');
  var resultsUI      = document.querySelector('.search-results');
  var searchInput    = document.querySelector('#search-str');
  var defaultResults = resultsUI.innerHTML;

  if(!fetch) {
    searchUI.display = "none";
  }
  var clearResults = (str) => {
    if (!str || !str.length || !searchIndex) {
      resultsUI.innerHTML = defaultResults;
    } else {
      while (resultsUI.firstChild) {
        resultsUI.removeChild(resultsUI.firstChild);
      }
    }
  };
  var fetchIndex = (file) => fetch(file).then((response) => response.json()).then((data) => {
    searchIndex = data.items;
  });
  var find = function (str) {
    clearResults(str);
    if (!str.length || !searchIndex) {
      return false;
    }
    str = str.toLowerCase();
    var results = [];
    for (var item of searchIndex) {
      var found = (item.title && item.title.toLowerCase().indexOf(str) >= 0) || (item.description && item.description.toLowerCase().indexOf(str) >= 0) || (item.tags && item.tags.join(' ').toLowerCase().indexOf(str) >= 0) || (item.content_text && item.content_text.toLowerCase().indexOf(str) >= 0);
      if (found != -1) {
        results.push(item);
        var listItem = document.createElement('div');
        listItem.innerHTML = `
            <article>
              <h3><a href="${item.url}">${item.title}</a></h3>
              <p class="excerpt">${item.content_text.substring(0, 100)}</p>
              <span class="tags">${item.tags.map((tag) => `<a rel="tag" class="tag ${tag}" href="/tag/${tag}">${tag}</a>`).join("")}</div>
              <time class="time" datetime="{{ item.date_published }}"><small>${new Date(item.date_published).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric'})}</small></time>
            </article>
            `;
          resultsUI.appendChild(listItem);
        }}
      return results;
    };
    searchInput.addEventListener('focus', () => fetchIndex("@base('/feed/feed.json')"));
    searchInput.addEventListener('keyup', () => find(searchInput.value));
</script>
