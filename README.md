# Lab 7: Add Movie Records

## Q1. Why should the form use POST instead of GET?

A form that uses GET sends the entered data in the URL, so the browser treats it like a normal page request. If the page is refreshed after a successful submit, the browser may try to send the same data again, creating duplicate records or a confusing repeated action. Using POST keeps the data in the request body and avoids this accidental resubmission pattern.

## Q2. What stops validation from saving the record?

Validation is handled by Laravel before the save code runs, and the request stops at the first failed rule. The controller does not need a manual if statement; Laravel throws a validation exception and sends the user back to the form with errors. The visitor is returned to the same page, with their values preserved, instead of being saved.

## Q3. Why does the success message not appear on every page?

The success message is stored in the session, and the layout checks it once for every page that renders. Because the controller redirects after the save, the next request loads a different page, and the message is displayed only once on that next response. After the page refreshes or the user navigates away, the session flash is gone, so it does not stay visible everywhere.

## Lab Activity 10: Your Own Lookup Table

### G1. Which column did you turn into a table, and why that one and not another?

I moved the repeated movie genre text into a `genres` lookup table because genres come from a fixed list and are shared by multiple movies. A year is a value belonging to an individual movie, not a reusable category with its own name.

### G2. What number did screenshot 6 show, and why exactly that number?

Before eager loading, the eight seeded movies require nine list queries: one query for the movies and one lazy relationship query for each movie's genre. After adding `with('genre')`, the movies and their genres are loaded in two queries instead of nine.

### G3. Why can a movie have more than one genre?

Movies and genres use a many-to-many relationship through the `genre_movie` pivot table. This lets one movie have genres such as Comedy, Action, and Historical Fiction, while each genre can be reused by many movies.
