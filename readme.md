# All Laravel relationships implemented in a ready to try Laravel skeleton app

## Installation

This project is ready to run.
An already configured and seeded Sqlite database is located at `/database/database.sqlite`.

## Relationships

### BelongsTo
 - `Article.author(Author)`
 - `Author.user(User)`
 - `Comment.article(Article)`
 - `Comment.user(User)`
 - `Like.user(User)`
 - `Report.user(User)`
 - `Review.user(User)`

### BelongsToMany
 - `Article.tags(Tag)`
 - `Tag.articles(Article)`

### HasMany
 - `Article.comments(Comment)`
 - `Author.articles(Article)`

### HasManyThrough
 - `Author.comments(Comment, Article)`

### HasOne
 - `User.author(Author)`
 - `User.comments(Author)`
 - `User.likes(Like)`
 - `User.reports(Report)`
 - `User.reviews(Review)`

### MorphedByMany
 - `Report.articles(Article, reportable)`
 - `Report.authors(Author, reportable)`
 - `Report.comments(Comment, reportable)`

### MorphMany
 - `Article.likes(Like, likeable)`
 - `Author.likes(Like, likeable)`
 - `Comment.likes(Like, likeable)`

### MorphTo
 - `Like.likeable()`
 - `Review.reviewable()`

### MorphToMany
 - `Article.reports(Report, reportable)`
 - `Author.reports(Report, reportable)`
 - `Comment.reports(Report, reportable)`

### MorphOne
 - `Article.review(Review, reviewable)`
 - `Comment.review(Review, reviewable)`
