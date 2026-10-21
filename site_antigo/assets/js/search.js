(function(window, document, undefined) {
  // Capitalises a string
  // Accepts:
  //   str: string
  // Returns:
  //   string
  var majusculeFirst = function(str) {
    return str.charAt(0).toUpperCase() + str.substring(1);
  };

  // Retrieves the value of a GET parameter with a given key
  // Accepts:
  //   param: string
  // Returns:
  //   string or null
  var getParam = function(param) {
    var queryString = window.location.search.substring(1),
        queries = queryString.split('&');
    for (var i in queries) {
      var pair = queries[i].split('=');
      if (pair[0] === param) {
        // Decode the parameter value, replacing %20 with a space etc.
        return decodeURI(pair[1]);
      }
    }
    return null;
  };

  // Filters posts with the condition `post['property'] == value`
  // Accepts:
  //   posts - array of post objects and a string
  //   property - string of post object property to compare
  //   value - filter value of property
  // Returns:
  //   array of post objects
  var filterPostsByPropertyValue = function(posts, property, value) {
    var filteredPosts = [];
    // The last element is a null terminator
    posts.pop();
    for (var i in posts) {
      var post = posts[i],
          prop = post[property];
      // Last element of tags is null
      post.tags.pop();

      // The property could be a string, such as a post's category,
      // or an array, such as a post's tags
      if (prop.constructor === String) {
        if (property == "description" && prop.toLowerCase().indexOf(value.toLowerCase()) >=0) {
          filteredPosts.push(post);
        }
        if (prop.toLowerCase() === value.toLowerCase()) {
          filteredPosts.push(post);
        }
      } else if (prop.constructor === Array) {
        for (var j in prop) {
          if (prop[j].toLowerCase() === value.toLowerCase()) {
            filteredPosts.push(post);
          }
        }
      }
    }

    return filteredPosts;
  };

  // Formats search results and appends them to the DOM
  // Accepts:
  //   property: string of object type we're displaying
  //   value: string of name of object we're displaying
  //   posts: array of post objects
  // Returns:
  //   undefined
  var layoutResultsPage = function(property, value, posts) {
    var $container = $('.wrapper');
    if ($container.length === 0) return;

    // Update the header
    $container.find('.search.text').append('"'+ majusculeFirst(value) + '" ('+ posts.length+')');

    // Loop through each post to format it
    $results = $container.find('.search.results');
    for (var i in posts) {
      // Create an unordered list of the post's tags
      var tagsList = '<ul class="tags">',
          post     = posts[i],
          tags     = post.tags;

      var item = $('<div class="item post"></div>');

      item.append('<a href="'+post.href+'" class="title">'+post.title+'</a>');
      item.append('<div class="url">'+post.url+'</div>');
      item.append('<div class="description">'+post.description+'</div>');

      $results.append(item);
    }
  };

  // Formats the search results page for no results
  // Accepts:
  //   property: string of object type we're displaying
  //   value: string of name of object we're displaying
  // Returns:
  //   undefined
  var noResultsPage = function(property, value) {
     $('.wrapper').find('.no-found').removeClass('ishide');
     $('.wrapper').find('.search.text').addClass('ishide');
  };

  // Replaces ERB-style tags with Liquid ones as we can't escape them in posts
  // Accepts:
  //   elements: jQuery elements in which to replace tags
  // Returns:
  //   undefined
  var replaceERBTags = function(elements) {
    elements.each(function() {
      // Only for text blocks at the moment as we'll strip highlighting otherwise
      var $this = $(this),
          txt   = $this.html();

      // Replace <%=  %>with {{ }}
      txt = txt.replace(new RegExp('&lt;%=(.+?)%&gt;', 'g'), '{{$1}}');
      // Replace <% %> with {% %}
      txt = txt.replace(new RegExp('&lt;%(.+?)%&gt;', 'g'), '{%$1%}');

      $this.html(txt);
    });
  };

  // Define the app object and expose it in the global scope
  window.alxPrc = {
    getParam: getParam,
    filterPostsByPropertyValue: filterPostsByPropertyValue,
    noResultsPage: noResultsPage,
    layoutResultsPage: layoutResultsPage,
    replaceERBTags: replaceERBTags
  };
})(window, window.document);

$(function() {
  var parameters = ['category', 'tags', 'description'];
  var map = {}
  for (var idx in parameters) {
    map[parameters[idx]] = alxPrc.getParam(parameters[idx]);
  }

  $.each(map, function(type, value) {
    if (value !== null) {
      $.getJSON('/search.json', function(data) {
        posts = alxPrc.filterPostsByPropertyValue(data, type, value);
        if (posts.length === 0) {
          alxPrc.noResultsPage(type, value);
        } else {
          alxPrc.layoutResultsPage(type, value, posts);
        }
      });
    }
  });

  // Replace ERB-style Liquid tags in highlighted code blocks...
  alxPrc.replaceERBTags($('div.highlight').find('code.text'));
  // ... and in inline code
  alxPrc.replaceERBTags($('p code'));
});