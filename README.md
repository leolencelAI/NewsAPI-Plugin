# NewsAPI-Plugin
Plugin for Wordpress to integrate a Newsfeed into your website


![1lookadminset](https://user-images.githubusercontent.com/81295725/230661607-b55d6419-37b6-4ad1-adaf-52dbfef324d5.png)

1. Page Size

You can manage the number of articles integrated in your feed. The maximum value
of your news feed is 100. You can’t fetch more than 100 articles with a developer
account!

2. Category

Category is set to business by default but you can change it to entertainment,
general, health, science, sports or technology. Be careful to only input one value
otherwise the plugin won’t be able to fetch news!

3. Api Key

Api Key is a string that enables NewsAPI connection. Without this string you can
fetch articles on newsapi.

4. Cache Option

Cache Option defines the time to save your news in your website wordpress before
fetching again from newsapi. It improves your website performance and avoids
fetching every time a user loads the page. Best is 1 hour or 1 day! Default is 1 hour.
Be careful if you change your cache option to 1 minute you could exceed your
NewsApi request limit (for example if a user loads every minute your NewsApi feed
and your cache option is set to 1 minute, after 100 minutes, your daily requests will
be exhausted. Not possible within an hour or day!)

![2preview](https://user-images.githubusercontent.com/81295725/230661617-ee0da1e4-95b2-48e5-bad8-14b056197568.png)
