# Rust-like iterator written in PHP
**This is raw version of iterator for PHP version 8.0**

In speed, of course, it is inferior to ordinary loop, but with enabled JIT, it is fast enough

### Some example:
```php
$punctuations = array(',', '.', '!', '?');
$iterators = [
    Iterator::range(0, 20)->rev(),
    [2, 4, 1, 23, 15, -1, 12],
    Iterator::chars('some, interesting string!')->filter(function($c) use (&$punctuations) {
        return !in_array($c, $punctuations);
    }),
    Iterator::repeat('!')->take(8),
    Iterator::repeat_with(fn() => mt_rand(0, 100))->take(4)
];

echo 'Result: ' . Iterator::from($iterators)->flatten()->join(', ') . PHP_EOL;
```