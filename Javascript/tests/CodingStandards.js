/**
 * General Coding Standards
 */

1. Naming Conventions

We use the case that the programming language we use defines as the standard.
For example, we use camelCase for Javascript, and snake_case for php.

2. File Names

Dashes are used for the file names, unless the used language requires otherwise (e.g. Java)

3. Indentation

Use an indent of 1 tab, which takes the space of 4 spaces.

Lines should have no trailing whitespace at the end.

4. Operators

All binary operators (operators that come between two values), such as +, -, =, !=, ==, >, etc. should have a space before and after the operator, for readability. For example, an assignment should be formatted as foo = bar;. Unary operators (operators that operate on only one value), such as ++, should not have a space between the operator and the variable or number they are operating on.

5. Brace Style

Braces should be used for multiline blocks in the style shown here:

if (condition) {
    action1();
    action2();
} elseif (condition2 && condition3) {
    action3();
    action4();
} else {
   defaultaction();
}

When defining a function, do it like so:

function myfunction(param1, param2) { ...

6. Quotes

Double or single quotes can be used at free will, except if the language we use requires otherwise.

7. Comments

Comments should be on a separate line immediately before the code line or block they reference. For example:

// Unselect all other contact categories.
db_query('UPDATE {contact} SET selected = 0');

To document a block of code, such as a file, function, class, method, constant, etc., the syntax we use is:

/**
 * Documentation here.
 */

jsDoc, phpDoc, javaDoc etc can be used when necessary

8. TODOs

To document known issues and development tasks in code, TODO statements may be used. Each TODO should form an atomic task.

//TODO: Make the date calculation more elegant.
