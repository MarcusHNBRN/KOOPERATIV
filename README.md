
# Sannikov Land

Sannikov Land was a phantom island in the Arctic Ocean. Its existence was conjectured by Yakov Sannikov, a Russian merchant and explorer, during his 1811 expedition. Sannikov reported seeing a vast land beyond the northern horizon while exploring the New Siberian Islands. This supposed land, named after him, spurred significant interest and led to numerous expeditions in the 19th century aimed at finding it. However, repeated searches yielded no evidence of its existence. The enduring mystery and allure of Sannikov Land contributed to its inclusion in Russian folklore and literature, notably in Vladimir Obruchev's 1926 science fiction novel "Sannikov Land." By the mid-20th century, scientific understanding and exploration of the Arctic had advanced sufficiently to confirm that Sannikov Land did not exist, and it was relegated to the category of mythical or phantom islands.

# Kooperativ

Hotel Kooperativ is a unique establishment that draws its design inspiration from East German aesthetics, reflecting the architectural and cultural heritage of the region. 

# Code review

1. index.php:4 - You may consider using the `__DIR__` magic constant to ensure that the path is correctly calculated. Not essential in this specific project, but will help if you ever want to scale up.
2. index.php:6-45 - Logic for checking available rooms could be moved separate php file, to avoid cluttering index.php.
3. room_selection.php:4-5 - Your app will crash if the included files are not found, so might as well use `require` or keep using `ìnclude`, but add some kind of user message saying the files couldn't be found.
4. room_selection.php:10-48 - Your entire booking logic resides in the file `room_selection.php`. The infrastructure of you app might be easier to follow for an outsider if booking and verification was moved to `booking.php`, for example.
5. room_selection.php:83 - Can't find reference to `$myAPIKey` anywhere else in the project.
6. room_selection.js:137 - Inline event handlers are generally considered bad prectice. Instead, it's better to handle events centrally via the dedicated `addEventListener`.
7. room_selection.php:144 - Inline styles make your code harder to maintain and update.
8. room_selection.php:190-207 - For clarity and reusability, this script could be moved to a separate js file.
9. style.css:109 - The color white is referenced as `white`, `#fff`, and `#ffffff`. For consistency, may as well define it among your color variables and use that exclusively.
10. images/image 3.png - Using blank spaces in file names is considered bad practice. Replace with underscore or hyphen.
