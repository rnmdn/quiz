<?php

function getQuestionPool($subject, $difficulty) {
    static $pools = [];
    
    if (!empty($pools)) {
        return $pools[$subject][$difficulty] ?? [];
    }
    
    $webEasy = [
        ['q' => "What does HTML stand for?", 'opts' => ['Hyper Text Markup Language', 'Home Tool Markup Language', 'Hyperlinks Text Markup', 'Hyper Text Makeup Language'], 'ans' => 'Hyper Text Markup Language'],
        ['q' => "Which HTML tag is used for the largest heading?", 'opts' => ['<heading>', '<h6>', '<h1>', '<head>'], 'ans' => '<h1>'],
        ['q' => "What does CSS stand for?", 'opts' => ['Computer Style Sheets', 'Cascading Style Sheets', 'Creative Style Sheets', 'Colorful Style Sheets'], 'ans' => 'Cascading Style Sheets'],
        ['q' => "Which HTML tag is used to insert an image?", 'opts' => ['<image>', '<img>', '<pic>', '<src>'], 'ans' => '<img>'],
        ['q' => "Choose the correct HTML element to define important text.", 'opts' => ['<important>', '<b>', '<strong>', '<i>'], 'ans' => '<strong>'],
        ['q' => "What is the correct HTML element for inserting a line break?", 'opts' => ['<lb>', '<break>', '<br>', '<tr>'], 'ans' => '<br>'],
        ['q' => "Which character is used to indicate an end tag in HTML?", 'opts' => ['*', '^', '<', '/'], 'ans' => '/'],
        ['q' => "How can you make a numbered list?", 'opts' => ['<list>', '<ul>', '<dl>', '<ol>'], 'ans' => '<ol>'],
        ['q' => "How can you make a bulleted list?", 'opts' => ['<ol>', '<list>', '<ul>', '<dl>'], 'ans' => '<ul>'],
        ['q' => "What is the correct HTML for creating a hyperlink?", 'opts' => ['<a url="http://test.com">Test</a>', '<a href="http://test.com">Test</a>', '<a>http://test.com</a>', '<link src="http://test.com">Test</link>'], 'ans' => '<a href="http://test.com">Test</a>'],
        ['q' => "Which HTML attribute specifies an alternate text for an image, if the image cannot be displayed?", 'opts' => ['title', 'alt', 'src', 'longdesc'], 'ans' => 'alt'],
        ['q' => "Which doctype is correct for HTML5?", 'opts' => ['<!DOCTYPE HTML5>', '<!DOCTYPE html>', '<!DOCTYPE HTML PUBLIC>', '<DOCTYPE html>'], 'ans' => '<!DOCTYPE html>'],
        ['q' => "Which HTML element is used to specify a footer for a document or section?", 'opts' => ['<bottom>', '<footer>', '<section>', '<end>'], 'ans' => '<footer>'],
        ['q' => "In HTML, what does the `<input type='text'>` element create?", 'opts' => ['A password field', 'A checkbox', 'A single-line text field', 'A submit button'], 'ans' => 'A single-line text field'],
        ['q' => "What does the `<title>` tag do?", 'opts' => ['Displays text on the page', 'Sets the title in the browser tab', 'Creates a large heading', 'Links a stylesheet'], 'ans' => 'Sets the title in the browser tab'],
        ['q' => "Which property is used to change the text color of an element?", 'opts' => ['fgcolor', 'color', 'text-color', 'font-color'], 'ans' => 'color'],
        ['q' => "How do you add a background color in CSS?", 'opts' => ['background-color: yellow;', 'color: yellow;', 'bg-color: yellow;', 'background: yellow text;'], 'ans' => 'background-color: yellow;'],
        ['q' => "Which HTML tag is used to define an internal style sheet?", 'opts' => ['<script>', '<style>', '<css>', '<link>'], 'ans' => '<style>'],
        ['q' => "Which CSS property controls the text size?", 'opts' => ['font-style', 'text-size', 'font-size', 'text-style'], 'ans' => 'font-size'],
        ['q' => "How do you display hyperlinks without an underline?", 'opts' => ['a {text-decoration:none;}', 'a {underline:none;}', 'a {decoration:no-underline;}', 'a {text-decoration:no-underline;}'], 'ans' => 'a {text-decoration:none;}']
    ];

    $webMedium = [
        ['q' => "How do you select an element with id='demo' in CSS?", 'opts' => ['.demo', '#demo', '*demo', 'demo'], 'ans' => '#demo'],
        ['q' => "How do you select elements with class name 'test'?", 'opts' => ['#test', '.test', '*test', 'test'], 'ans' => '.test'],
        ['q' => "Inside which HTML element do we put the JavaScript?", 'opts' => ['<script>', '<javascript>', '<js>', '<scripting>'], 'ans' => '<script>'],
        ['q' => "When designing a dark mode UI, which hex code represents a solid black background?", 'opts' => ['#FFFFFF', '#000000', '#FF0000', '#CCCCCC'], 'ans' => '#000000'],
        ['q' => "If your branding requires a 'gold standard' accent color, which hex code is commonly used for Gold?", 'opts' => ['#FFD700', '#00FF00', '#0000FF', '#FF00FF'], 'ans' => '#FFD700'],
        ['q' => "How do you write 'Hello World' in a JavaScript alert box?", 'opts' => ['msgBox("Hello World");', 'alertBox("Hello World");', 'msg("Hello World");', 'alert("Hello World");'], 'ans' => 'alert("Hello World");'],
        ['q' => "How do you create a function in JavaScript?", 'opts' => ['function = myFunction()', 'function myFunction()', 'function:myFunction()', 'create myFunction()'], 'ans' => 'function myFunction()'],
        ['q' => "How do you call a function named 'myFunction'?", 'opts' => ['call function myFunction()', 'call myFunction()', 'myFunction()', 'execute myFunction()'], 'ans' => 'myFunction()'],
        ['q' => "How to write an IF statement in JavaScript?", 'opts' => ['if i = 5 then', 'if i == 5 then', 'if (i == 5)', 'if i = 5'], 'ans' => 'if (i == 5)'],
        ['q' => "How does a WHILE loop start?", 'opts' => ['while i = 1 to 10', 'while (i <= 10; i++)', 'while (i <= 10)', 'while (i=0 to 10)'], 'ans' => 'while (i <= 10)'],
        ['q' => "Which CSS property controls the spacing BETWEEN HTML elements?", 'opts' => ['padding', 'margin', 'border', 'spacing'], 'ans' => 'margin'],
        ['q' => "Which CSS property controls the space INSIDE an HTML element, around its content?", 'opts' => ['margin', 'padding', 'spacing', 'border-spacing'], 'ans' => 'padding'],
        ['q' => "How do you make a list that lists its items with squares?", 'opts' => ['list-type: square;', 'list-style-type: square;', 'ul {square}', 'list: square;'], 'ans' => 'list-style-type: square;'],
        ['q' => "What is the default value of the position property in CSS?", 'opts' => ['relative', 'fixed', 'absolute', 'static'], 'ans' => 'static'],
        ['q' => "How do you group multiple CSS selectors to apply the same style?", 'opts' => ['Separate with spaces', 'Separate with commas', 'Separate with plus signs', 'You cannot group them'], 'ans' => 'Separate with commas'],
        ['q' => "What is the correct way to add a comment in JavaScript?", 'opts' => ['', '// comment', "' comment", '** comment **'], 'ans' => '// comment'],
        ['q' => "Which event occurs when the user clicks on an HTML element?", 'opts' => ['onmouseclick', 'onchange', 'onclick', 'onmouseover'], 'ans' => 'onclick'],
        ['q' => "How do you declare a JavaScript variable?", 'opts' => ['v carName;', 'variable carName;', 'var carName;', 'declare carName;'], 'ans' => 'var carName;'],
        ['q' => "Which operator is used to assign a value to a variable?", 'opts' => ['*', '-', '=', 'x'], 'ans' => '='],
        ['q' => "What will `typeof []` return in JavaScript?", 'opts' => ['array', 'object', 'string', 'undefined'], 'ans' => 'object']
    ];

    $webHard = [
        ['q' => "Which of the following is NOT a valid JavaScript variable declaration keyword?", 'opts' => ['var', 'let', 'const', 'def'], 'ans' => 'def'],
        ['q' => "What is the correct syntax for referring to an external script called 'xxx.js'?", 'opts' => ['<script href="xxx.js">', '<script name="xxx.js">', '<script src="xxx.js">', '<link src="xxx.js">'], 'ans' => '<script src="xxx.js">'],
        ['q' => "How do you round the number 7.25, to the nearest integer in JS?", 'opts' => ['round(7.25)', 'Math.rnd(7.25)', 'Math.round(7.25)', 'rnd(7.25)'], 'ans' => 'Math.round(7.25)'],
        ['q' => "Which CSS layout module is designed for one-dimensional layouts (rows or columns)?", 'opts' => ['CSS Grid', 'CSS Flexbox', 'CSS Float', 'CSS Columns'], 'ans' => 'CSS Flexbox'],
        ['q' => "Which CSS layout module is best suited for complex, two-dimensional web interfaces?", 'opts' => ['Flexbox', 'CSS Grid', 'Block Layout', 'Inline-Block'], 'ans' => 'CSS Grid'],
        ['q' => "In JavaScript, what does the '===' operator do?", 'opts' => ['Assigns a value', 'Compares value only', 'Compares value and data type', 'Checks if a variable is empty'], 'ans' => 'Compares value and data type'],
        ['q' => "What is the output of `console.log(typeof NaN);`?", 'opts' => ['NaN', 'number', 'undefined', 'object'], 'ans' => 'number'],
        ['q' => "Which method converts a JSON string into a JavaScript object?", 'opts' => ['JSON.parse()', 'JSON.stringify()', 'JSON.toObject()', 'JSON.convert()'], 'ans' => 'JSON.parse()'],
        ['q' => "What is a JavaScript Promise?", 'opts' => ['A synchronous callback', 'An object representing the eventual completion or failure of an asynchronous operation', 'A loop constructor', 'A strict mode enforcement'], 'ans' => 'An object representing the eventual completion or failure of an asynchronous operation'],
        ['q' => "Which CSS property is used to create a glassmorphism blur effect behind an element?", 'opts' => ['opacity', 'filter: blur()', 'backdrop-filter', 'background-blend-mode'], 'ans' => 'backdrop-filter'],
        ['q' => "In CSS, what does the `z-index` property control?", 'opts' => ['Zoom level', 'Horizontal alignment', 'The stack order of an element', 'Animation speed'], 'ans' => 'The stack order of an element'],
        ['q' => "Which keyword is used to handle exceptions in JavaScript?", 'opts' => ['try...catch', 'error...handle', 'if...else', 'throw...stop'], 'ans' => 'try...catch'],
        ['q' => "What does the CSS `!important` rule do?", 'opts' => ['Highlights text', 'Overrides all previous styling rules for that specific property', 'Makes the element load faster', 'Validates the CSS file'], 'ans' => 'Overrides all previous styling rules for that specific property'],
        ['q' => "How do you permanently store data in the user's browser using JavaScript?", 'opts' => ['sessionStorage.setItem()', 'document.cookie', 'localStorage.setItem()', 'window.database()'], 'ans' => 'localStorage.setItem()'],
        ['q' => "What is the purpose of the `Array.map()` method in JS?", 'opts' => ['To find a specific element', 'To iterate and modify elements, returning a new array', 'To sort an array alphabetically', 'To remove the last element'], 'ans' => 'To iterate and modify elements, returning a new array'],
        ['q' => "Which feature allows you to define variables in pure CSS?", 'opts' => ['CSS Arrays', 'Custom Properties (--var-name)', 'SCSS only', 'JS Injectors'], 'ans' => 'Custom Properties (--var-name)'],
        ['q' => "What does the `fetch()` API return by default?", 'opts' => ['A string', 'An array', 'A Promise', 'HTML content'], 'ans' => 'A Promise'],
        ['q' => "How do you prevent a form from submitting traditionally in vanilla JavaScript?", 'opts' => ['event.stop()', 'event.preventDefault()', 'form.halt()', 'return false'], 'ans' => 'event.preventDefault()'],
        ['q' => "Which of these is a JavaScript module bundler?", 'opts' => ['Sass', 'Webpack', 'NPM', 'React'], 'ans' => 'Webpack'],
        ['q' => "What does CORS stand for in web development?", 'opts' => ['Cross-Origin Resource Sharing', 'Cascading Object Rendering System', 'Centralized Online Routing Server', 'Cross-OS Rendering Script'], 'ans' => 'Cross-Origin Resource Sharing']
    ];

    $appEasy = [
        ['q' => "Which language is primarily promoted by Google for Android app development?", 'opts' => ['Swift', 'Kotlin', 'Objective-C', 'C#'], 'ans' => 'Kotlin'],
        ['q' => "What is the official IDE for Android development?", 'opts' => ['Eclipse', 'Visual Studio', 'Android Studio', 'Xcode'], 'ans' => 'Android Studio'],
        ['q' => "In Android, what file format is used to define the user interface layout?", 'opts' => ['Java', 'Manifest', 'XML', 'Gradle'], 'ans' => 'XML'],
        ['q' => "What is an 'Activity' in Android?", 'opts' => ['A background service', 'A single screen with a user interface', 'A database table', 'A network request'], 'ans' => 'A single screen with a user interface'],
        ['q' => "Which company develops the iOS operating system?", 'opts' => ['Google', 'Microsoft', 'Apple', 'Samsung'], 'ans' => 'Apple'],
        ['q' => "What does 'SDK' stand for?", 'opts' => ['Software Development Kit', 'System Design Kit', 'Standard Device Kernel', 'Software Data Key'], 'ans' => 'Software Development Kit'],
        ['q' => "Which UI component is used to display text to the user in Android?", 'opts' => ['Button', 'TextView', 'EditText', 'ImageView'], 'ans' => 'TextView'],
        ['q' => "Which UI component allows a user to enter text?", 'opts' => ['TextView', 'InputBox', 'EditText', 'TextEntry'], 'ans' => 'EditText'],
        ['q' => "What is the name of the file that contains all app permissions and package details?", 'opts' => ['build.gradle', 'AndroidManifest.xml', 'strings.xml', 'MainActivity.java'], 'ans' => 'AndroidManifest.xml'],
        ['q' => "Which folder in Android Studio holds image assets?", 'opts' => ['res/layout', 'res/values', 'res/drawable', 'src/main'], 'ans' => 'res/drawable'],
        ['q' => "What is the primary language used to build iOS apps?", 'opts' => ['Java', 'Kotlin', 'Swift', 'C++'], 'ans' => 'Swift'],
        ['q' => "How do you define a constant in Kotlin?", 'opts' => ['var', 'let', 'val', 'const'], 'ans' => 'val'],
        ['q' => "What file defines the colors used across an Android app?", 'opts' => ['colors.xml', 'styles.css', 'themes.xml', 'ui.json'], 'ans' => 'colors.xml'],
        ['q' => "Which layout aligns children linearly, either horizontally or vertically?", 'opts' => ['ConstraintLayout', 'RelativeLayout', 'LinearLayout', 'FrameLayout'], 'ans' => 'LinearLayout'],
        ['q' => "What component handles background processes that don't need a UI?", 'opts' => ['Activity', 'Fragment', 'Service', 'Intent'], 'ans' => 'Service'],
        ['q' => "How do you run an Android app on your computer during development?", 'opts' => ['Using a web browser', 'Using an Emulator', 'Burning an APK to a disc', 'Running it in terminal'], 'ans' => 'Using an Emulator'],
        ['q' => "What is the file extension for a compiled Android application package?", 'opts' => ['.exe', '.dmg', '.apk', '.app'], 'ans' => '.apk'],
        ['q' => "Which element is used to trigger an action when clicked?", 'opts' => ['TextView', 'Button', 'Spinner', 'CardView'], 'ans' => 'Button'],
        ['q' => "Where are string constants (like app name) typically stored to support translations?", 'opts' => ['strings.xml', 'text.xml', 'words.xml', 'MainActivity.kt'], 'ans' => 'strings.xml'],
        ['q' => "What is the process of finding and fixing bugs in an app called?", 'opts' => ['Compiling', 'Executing', 'Debugging', 'Deploying'], 'ans' => 'Debugging']
    ];

    $appMedium = [
        ['q' => "What does 'API' stand for?", 'opts' => ['Application Program Interface', 'Applied Programming Interface', 'Application Protocol Interface', 'App Program Integration'], 'ans' => 'Application Program Interface'],
        ['q' => "In Android, what component is used to display a brief, temporary pop-up message to the user?", 'opts' => ['Dialog', 'Toast', 'Snackbar', 'Notification'], 'ans' => 'Toast'],
        ['q' => "If you want to trigger a pop-up alert dialog welcoming users to your 'BLACKPINK' fan app, which builder class do you use?", 'opts' => ['Toast.Builder', 'AlertDialog.Builder', 'Popup.Creator', 'NotificationManager'], 'ans' => 'AlertDialog.Builder'],
        ['q' => "Which method is called first in the Android Activity lifecycle?", 'opts' => ['onStart()', 'onResume()', 'onCreate()', 'onInit()'], 'ans' => 'onCreate()'],
        ['q' => "What is the purpose of the AndroidManifest.xml file?", 'opts' => ['To write UI code', 'To store images', 'To define app structure, permissions, and components', 'To manage the database'], 'ans' => 'To define app structure, permissions, and components'],
        ['q' => "In Kotlin, which keyword is used to declare a variable that cannot be reassigned (immutable)?", 'opts' => ['var', 'let', 'val', 'const'], 'ans' => 'val'],
        ['q' => "Which Android component represents a reusable portion of UI within an Activity?", 'opts' => ['Intent', 'Service', 'Fragment', 'BroadcastReceiver'], 'ans' => 'Fragment'],
        ['q' => "How do you pass data between two different Activities in Android?", 'opts' => ['Using SharedPreferences', 'Using Intents with putExtra()', 'Using a global static variable', 'All of the above'], 'ans' => 'All of the above'],
        ['q' => "Which file is used to manage dependencies and build configurations in an Android project?", 'opts' => ['AndroidManifest.xml', 'build.gradle', 'settings.json', 'pom.xml'], 'ans' => 'build.gradle'],
        ['q' => "What does UI stand for?", 'opts' => ['User Interface', 'Unified Integration', 'User Input', 'Universal Identity'], 'ans' => 'User Interface'],
        ['q' => "What does UX stand for?", 'opts' => ['User Execution', 'User Experience', 'Unified X-axis', 'Universal Exchange'], 'ans' => 'User Experience'],
        ['q' => "Which XML attribute assigns a unique identifier to a UI component?", 'opts' => ['android:name', 'android:id', 'android:tag', 'android:key'], 'ans' => 'android:id'],
        ['q' => "If you are designing a music player playing a 'Twice' song in the background, what component do you use?", 'opts' => ['Activity', 'BroadcastReceiver', 'Service', 'ContentProvider'], 'ans' => 'Service'],
        ['q' => "Which layout manager allows you to position elements relative to each other or the parent bounds?", 'opts' => ['LinearLayout', 'ConstraintLayout', 'FrameLayout', 'TableLayout'], 'ans' => 'ConstraintLayout'],
        ['q' => "In iOS Swift, which keyword is used to declare a variable whose value can change?", 'opts' => ['var', 'val', 'let', 'mut'], 'ans' => 'var'],
        ['q' => "What is used to securely store small amounts of primitive data in Android?", 'opts' => ['SQLite', 'SharedPreferences', 'Internal Storage', 'Room Database'], 'ans' => 'SharedPreferences'],
        ['q' => "Which component responds to system-wide announcements, like 'Battery Low'?", 'opts' => ['Service', 'Activity', 'BroadcastReceiver', 'IntentFilter'], 'ans' => 'BroadcastReceiver'],
        ['q' => "What does an explicit Intent do?", 'opts' => ['Asks the system to find an app to handle an action', 'Starts a specific component by explicitly naming its class', 'Sends an email', 'Opens a web page'], 'ans' => 'Starts a specific component by explicitly naming its class'],
        ['q' => "What unit of measurement should be used for font sizes in Android XML?", 'opts' => ['dp (Density-independent Pixels)', 'px (Pixels)', 'sp (Scale-independent Pixels)', 'pt (Points)'], 'ans' => 'sp (Scale-independent Pixels)'],
        ['q' => "What tool is used in Android Studio to visually design layouts?", 'opts' => ['Layout Editor', 'XML Parser', 'Canvas Designer', 'UI Builder'], 'ans' => 'Layout Editor']
    ];

    $appHard = [
        ['q' => "Which architecture pattern is commonly used in iOS apps?", 'opts' => ['MVC', 'MVP', 'MVVM', 'VIPER'], 'ans' => 'MVC'],
        ['q' => "In Android, what is an 'Intent' primarily used for?", 'opts' => ['Connecting to a database', 'Starting another Activity or service', 'Drawing graphics', 'Parsing JSON'], 'ans' => 'Starting another Activity or service'],
        ['q' => "When building a highly interactive UI with a long scrolling list in Android, which component is most memory-efficient?", 'opts' => ['ListView', 'ScrollView', 'RecyclerView', 'LinearLayout'], 'ans' => 'RecyclerView'],
        ['q' => "In Kotlin, what feature allows you to handle asynchronous tasks without blocking the main thread cleanly?", 'opts' => ['Threads', 'Callbacks', 'Coroutines', 'AsyncTasks'], 'ans' => 'Coroutines'],
        ['q' => "What is the primary build automation system used in Android Studio?", 'opts' => ['Maven', 'Ant', 'Make', 'Gradle'], 'ans' => 'Gradle'],
        ['q' => "What design pattern does Google recommend for modern Android development?", 'opts' => ['MVC (Model-View-Controller)', 'MVVM (Model-View-ViewModel)', 'Singleton', 'Factory'], 'ans' => 'MVVM (Model-View-ViewModel)'],
        ['q' => "Which Jetpack library provides an abstraction layer over SQLite?", 'opts' => ['Retrofit', 'Room', 'Glide', 'DataStore'], 'ans' => 'Room'],
        ['q' => "If you are fetching data from a REST API in an Android app, which library is most commonly used?", 'opts' => ['Retrofit', 'Picasso', 'Room', 'Dagger'], 'ans' => 'Retrofit'],
        ['q' => "What is the purpose of Dependency Injection frameworks like Hilt or Dagger?", 'opts' => ['To inject CSS into XML', 'To manage UI states', 'To supply classes with their required dependencies dynamically', 'To secure API keys'], 'ans' => 'To supply classes with their required dependencies dynamically'],
        ['q' => "What happens during the `onDestroy()` phase of an Activity?", 'opts' => ['The UI is paused', 'The Activity is brought to the foreground', 'The Activity is permanently destroyed and memory is freed', 'The app crashes'], 'ans' => 'The Activity is permanently destroyed and memory is freed'],
        ['q' => "Which UI component is used to manage navigation between multiple Fragments using a bottom bar?", 'opts' => ['Toolbar', 'BottomNavigationView', 'ViewPager', 'DrawerLayout'], 'ans' => 'BottomNavigationView'],
        ['q' => "In Swift, what is an 'Optional'?", 'opts' => ['A variable that might contain a value, or might be nil', 'A setting in Xcode', 'An alternative UI layout', 'A premium app feature'], 'ans' => 'A variable that might contain a value, or might be nil'],
        ['q' => "What is the modern declarative UI toolkit introduced by Google for Android?", 'opts' => ['XML Layouts', 'Flutter', 'Jetpack Compose', 'React Native'], 'ans' => 'Jetpack Compose'],
        ['q' => "What is the modern declarative UI toolkit introduced by Apple for iOS?", 'opts' => ['UIKit', 'Storyboards', 'SwiftUI', 'Interface Builder'], 'ans' => 'SwiftUI'],
        ['q' => "Which Kotlin function is used to execute a block of code only if the object is not null?", 'opts' => ['.let {}', '.run {}', '.apply {}', '.also {}'], 'ans' => '.let {}'],
        ['q' => "What is 'ANR' in Android context?", 'opts' => ['Android Native Runtime', 'Application Not Responding', 'Auto Network Routing', 'Activity Navigation Route'], 'ans' => 'Application Not Responding'],
        ['q' => "How do you handle runtime permissions introduced in Android 6.0?", 'opts' => ['Define them in XML only', 'Ask the user explicitly via a system dialog during runtime', 'Pay for a developer license', 'Bypass them using root access'], 'ans' => 'Ask the user explicitly via a system dialog during runtime'],
        ['q' => "Which component manages a RecyclerView's item positioning?", 'opts' => ['Adapter', 'ViewHolder', 'LayoutManager', 'ItemAnimator'], 'ans' => 'LayoutManager'],
        ['q' => "What is a Memory Leak in mobile development?", 'opts' => ['When the battery drains too fast', 'When objects are no longer needed but the Garbage Collector cannot remove them', 'When network requests fail', 'When the app size exceeds 100MB'], 'ans' => 'When objects are no longer needed but the Garbage Collector cannot remove them'],
        ['q' => "What tool allows you to inspect layouts, view hierarchy, and attributes of an app running on a device?", 'opts' => ['Logcat', 'Profiler', 'Layout Inspector', 'APK Analyzer'], 'ans' => 'Layout Inspector']
    ];

    $intEasy = [
        ['q' => "What does PHP stand for?", 'opts' => ['Personal Home Page', 'Preprocessor Hypertext', 'PHP: Hypertext Preprocessor', 'Public Host Page'], 'ans' => 'PHP: Hypertext Preprocessor'],
        ['q' => "How do you start a PHP script?", 'opts' => ['<script>', '<?php', '<php>', '<!php>'], 'ans' => '<?php'],
        ['q' => "Which symbol is used to declare a variable in PHP?", 'opts' => ['!', '$', '&', '#'], 'ans' => '$'],
        ['q' => "How do you output text to the screen in PHP?", 'opts' => ['Document.Write()', 'console.log()', 'echo', 'print_out'], 'ans' => 'echo'],
        ['q' => "If you have an array of K-pop groups like ['BTS', 'BLACKPINK', 'Twice'], which PHP function counts the total elements?", 'opts' => ['length()', 'size()', 'count()', 'total()'], 'ans' => 'count()'],
        ['q' => "How do you end a PHP statement?", 'opts' => ['.', '</php>', ';', ':'], 'ans' => ';'],
        ['q' => "What is the correct way to write a single-line comment in PHP?", 'opts' => ['', '// comment', '* comment', '# comment'], 'ans' => '// comment'],
        ['q' => "Which of the following is a valid PHP variable name?", 'opts' => ['$1name', '$first-name', '$first_name', '$first name'], 'ans' => '$first_name'],
        ['q' => "What is the result of 5 % 2 in PHP?", 'opts' => ['2.5', '2', '1', '0'], 'ans' => '1'],
        ['q' => "How do you define a constant in PHP?", 'opts' => ['const()', 'define()', 'constant()', 'let'], 'ans' => 'define()'],
        ['q' => "Which logical operator means 'AND' in PHP?", 'opts' => ['||', '&&', '!', '=='], 'ans' => '&&'],
        ['q' => "Which logical operator means 'OR' in PHP?", 'opts' => ['&&', '!', '||', '!='], 'ans' => '||'],
        ['q' => "What is the correct way to increment a variable `\$x` by 1?", 'opts' => ['$x++;', '$x =+ 1;', 'x++;', '++$x++;'], 'ans' => '$x++;'],
        ['q' => "Which function returns the length of a string in PHP?", 'opts' => ['str_length()', 'strlen()', 'length()', 'count()'], 'ans' => 'strlen()'],
        ['q' => "Which data type is returned by the `is_numeric()` function?", 'opts' => ['String', 'Integer', 'Boolean', 'Float'], 'ans' => 'Boolean'],
        ['q' => "How do you combine (concatenate) two strings in PHP?", 'opts' => ['Using the + operator', 'Using the . operator', 'Using the & operator', 'Using the , operator'], 'ans' => 'Using the . operator'],
        ['q' => "What is an array in PHP?", 'opts' => ['A single variable', 'A function', 'A special variable that holds multiple values', 'A database table'], 'ans' => 'A special variable that holds multiple values'],
        ['q' => "Which loop structure runs a block of code a specified number of times?", 'opts' => ['while', 'do...while', 'for', 'foreach'], 'ans' => 'for'],
        ['q' => "Which loop is exclusively used to loop through arrays?", 'opts' => ['for', 'while', 'foreach', 'do...while'], 'ans' => 'foreach'],
        ['q' => "How do you write 'Not Equal To' in PHP?", 'opts' => ['!==', '!=', '<>', 'Both != and <>'], 'ans' => 'Both != and <>']
    ];

    $intMedium = [
        ['q' => "Which superglobal holds form data sent via POST?", 'opts' => ['$_GET', '$_POST', '$_REQUEST', '$_SERVER'], 'ans' => '$_POST'],
        ['q' => "In a debate about login security, which PHP control structure is best suited for executing code only if passwords match?", 'opts' => ['switch', 'while loop', 'if/else', 'foreach loop'], 'ans' => 'if/else'],
        ['q' => "What is the correct way to include a file named 'config.php' and stop execution if it fails?", 'opts' => ['include "config.php";', 'require "config.php";', 'import "config.php";', 'load "config.php";'], 'ans' => 'require "config.php";'],
        ['q' => "If an academic reporting group has 8 members in an array, how do you loop through all members efficiently?", 'opts' => ['if ($members < 8)', 'foreach ($members as $member)', 'while ($member == 8)', 'switch ($members)'], 'ans' => 'foreach ($members as $member)'],
        ['q' => "How do you create an array in PHP?", 'opts' => ['$cars = "Volvo", "BMW";', '$cars = array("Volvo", "BMW");', '$cars = (Volvo, BMW);', '$cars = {"Volvo", "BMW"};'], 'ans' => '$cars = array("Volvo", "BMW");'],
        ['q' => "In a Chinese New Year script, if you need to assign a budget variable `\$angPao` and check if it's strictly greater than 100, which comparison operator is used?", 'opts' => ['=', '==', '>', '>='], 'ans' => '>'],
        ['q' => "What is the difference between `include` and `require` in PHP?", 'opts' => ['No difference', 'Include stops execution on failure, require throws a warning', 'Require stops execution on failure, include throws a warning', 'Require is for HTML, include is for PHP'], 'ans' => 'Require stops execution on failure, include throws a warning'],
        ['q' => "Which superglobal array collects form data sent with the GET method?", 'opts' => ['$_POST', '$_GET', '$_SERVER', '$_SESSION'], 'ans' => '$_GET'],
        ['q' => "What does `\$_SERVER['PHP_SELF']` return?", 'opts' => ['The server IP', 'The filename of the currently executing script', 'The PHP version', 'The root directory'], 'ans' => 'The filename of the currently executing script'],
        ['q' => "Which function is used to redirect a user to a different page in PHP?", 'opts' => ['redirect("page.php");', 'header("Location: page.php");', 'nav("page.php");', 'location.replace("page.php");'], 'ans' => 'header("Location: page.php");'],
        ['q' => "What is a PHP Session?", 'opts' => ['A cookie stored on the user machine', 'A way to store information (in variables) to be used across multiple pages', 'A secure database connection', 'A server timeout limit'], 'ans' => 'A way to store information (in variables) to be used across multiple pages'],
        ['q' => "Which function destroys all data registered to a session?", 'opts' => ['session_destroy()', 'session_unset()', 'session_kill()', 'session_end()'], 'ans' => 'session_destroy()'],
        ['q' => "How do you get the current date and time in PHP?", 'opts' => ['time()', 'date()', 'now()', 'current_date()'], 'ans' => 'date()'],
        ['q' => "What is an associative array in PHP?", 'opts' => ['An array with numeric indexes', 'An array that uses named keys that you assign to them', 'A multi-dimensional array', 'An array of objects'], 'ans' => 'An array that uses named keys that you assign to them'],
        ['q' => "How do you access the value 'Gold' in `\$colors = ['primary' => 'Gold', 'dark' => 'Black'];`?", 'opts' => ['$colors[0]', '$colors[1]', '$colors["primary"]', '$colors.primary'], 'ans' => '$colors["primary"]'],
        ['q' => "Which built-in function is used to search an array for a specific value?", 'opts' => ['array_find()', 'in_array()', 'search_array()', 'array_search_value()'], 'ans' => 'in_array()'],
        ['q' => "What does `trim()` do in PHP?", 'opts' => ['Cuts a string in half', 'Removes whitespace from both sides of a string', 'Deletes a variable', 'Rounds a float to an integer'], 'ans' => 'Removes whitespace from both sides of a string'],
        ['q' => "Which function is commonly used to sanitize user input to prevent XSS attacks?", 'opts' => ['clean_string()', 'strip_tags()', 'htmlspecialchars()', 'sanitize()'], 'ans' => 'htmlspecialchars()'],
        ['q' => "What is the scope of a variable declared outside a function?", 'opts' => ['Local scope', 'Global scope', 'Static scope', 'Block scope'], 'ans' => 'Global scope'],
        ['q' => "How do you access a global variable inside a function in PHP?", 'opts' => ['Use the `global` keyword', 'Pass it via GET', 'It is accessible automatically', 'Use `window.var`'], 'ans' => 'Use the `global` keyword']
    ];

    $intHard = [
        ['q' => "What is the output of `echo 2 + '3 apples';` in modern PHP?", 'opts' => ['2', '5', '23 apples', 'Throws a TypeError'], 'ans' => 'Throws a TypeError'],
        ['q' => "Which function is used to start a session in PHP?", 'opts' => ['session_begin()', 'start_session()', 'session_start()', 'init_session()'], 'ans' => 'session_start()'],
        ['q' => "In Object-Oriented PHP, which keyword is used to refer to the current instance of a class?", 'opts' => ['self', 'this', '$this', 'current'], 'ans' => '$this'],
        ['q' => "What does PDO stand for in PHP database connections?", 'opts' => ['PHP Data Objects', 'PHP Database Operations', 'Public Data Operator', 'PHP Database Optimizer'], 'ans' => 'PHP Data Objects'],
        ['q' => "Which function prevents SQL injection when taking user input for a standard MySQLi query?", 'opts' => ['htmlspecialchars()', 'mysqli_real_escape_string()', 'trim()', 'strip_tags()'], 'ans' => 'mysqli_real_escape_string()'],
        ['q' => "In OOP, what is the method called that automatically executes when an object is created?", 'opts' => ['__build()', '__construct()', 'initialize()', 'setup()'], 'ans' => '__construct()'],
        ['q' => "How do you define a class in PHP?", 'opts' => ['class MyClass {}', 'new Class MyClass {}', 'create class MyClass {}', 'def MyClass {}'], 'ans' => 'class MyClass {}'],
        ['q' => "Which keyword is used to inherit from a parent class in PHP?", 'opts' => ['inherits', 'extends', 'implements', 'uses'], 'ans' => 'extends'],
        ['q' => "What is the difference between `==` and `===` in PHP?", 'opts' => ['No difference', '=== compares value and type, == compares value only', '== compares value and type, === compares value only', '=== is an assignment operator'], 'ans' => '=== compares value and type, == compares value only'],
        ['q' => "Which PHP function is best for securely hashing a user password before storing it?", 'opts' => ['md5()', 'sha1()', 'base64_encode()', 'password_hash()'], 'ans' => 'password_hash()'],
        ['q' => "How do you verify a password hashed with `password_hash()`?", 'opts' => ['password_verify()', 'hash_check()', 'check_password()', 'md5_verify()'], 'ans' => 'password_verify()'],
        ['q' => "In a try-catch block, what object is thrown when an error occurs?", 'opts' => ['ErrorObject', 'Exception', 'Fault', 'Crash'], 'ans' => 'Exception'],
        ['q' => "What is a trait in PHP?", 'opts' => ['A variable type', 'A mechanism for code reuse in single inheritance languages', 'A database connection string', 'An HTML template'], 'ans' => 'A mechanism for code reuse in single inheritance languages'],
        ['q' => "What does the `static` keyword do when applied to a class method?", 'opts' => ['Makes the method private', 'Allows the method to be called without instantiating the class', 'Prevents the method from being overridden', 'Caches the output'], 'ans' => 'Allows the method to be called without instantiating the class'],
        ['q' => "How do you access a static method named `calc()` in a class named `Math`?", 'opts' => ['Math->calc()', 'Math::calc()', 'Math.calc()', 'Math:calc()'], 'ans' => 'Math::calc()'],
        ['q' => "Which design pattern restricts the instantiation of a class to one single instance?", 'opts' => ['Factory', 'Observer', 'Singleton', 'MVC'], 'ans' => 'Singleton'],
        ['q' => "When using PDO, what is the safest way to execute a query with user inputs?", 'opts' => ['Direct concatenation', 'Prepared Statements with bound parameters', 'Using md5 on inputs', 'Using $_SERVER vars'], 'ans' => 'Prepared Statements with bound parameters'],
        ['q' => "What does the `explode()` function do?", 'opts' => ['Deletes an array', 'Splits a string by a string into an array', 'Terminates the script', 'Unzips a file'], 'ans' => 'Splits a string by a string into an array'],
        ['q' => "What does the `implode()` function do?", 'opts' => ['Joins array elements with a string', 'Compresses a file', 'Combines two objects', 'Reduces database size'], 'ans' => 'Joins array elements with a string'],
        ['q' => "Which of these is the correct way to set a cookie in PHP?", 'opts' => ['$_COOKIE["name"] = "value";', 'setcookie("name", "value", time() + 3600);', 'make_cookie("name", "value");', 'cookie_set("name", "value");'], 'ans' => 'setcookie("name", "value", time() + 3600);']
    ];

    $dbEasy = [
        ['q' => "Which SQL statement is used to extract data from a database?", 'opts' => ['INSERT', 'UPDATE', 'SELECT', 'DELETE'], 'ans' => 'SELECT'],
        ['q' => "Which SQL statement is used to update data in a database?", 'opts' => ['SAVE', 'MODIFY', 'UPDATE', 'CHANGE'], 'ans' => 'UPDATE'],
        ['q' => "Which SQL statement is used to delete data from a database?", 'opts' => ['REMOVE', 'DELETE', 'COLLAPSE', 'DROP'], 'ans' => 'DELETE'],
        ['q' => "What does SQL stand for?", 'opts' => ['Structured Query Language', 'Strong Question Language', 'Structured Question Language', 'Standard Query Logic'], 'ans' => 'Structured Query Language'],
        ['q' => "Which SQL clause is used to filter records?", 'opts' => ['FILTER', 'WHERE', 'HAVING', 'ORDER BY'], 'ans' => 'WHERE'],
        ['q' => "Which SQL statement is used to insert new data into a database?", 'opts' => ['ADD RECORD', 'INSERT INTO', 'INSERT NEW', 'ADD INTO'], 'ans' => 'INSERT INTO'],
        ['q' => "How do you select all columns from a table named 'Persons'?", 'opts' => ['SELECT * FROM Persons', 'SELECT Persons', 'SELECT *.Persons', 'EXTRACT ALL FROM Persons'], 'ans' => 'SELECT * FROM Persons'],
        ['q' => "How do you select a column named 'FirstName' from a table named 'Persons'?", 'opts' => ['EXTRACT FirstName FROM Persons', 'SELECT FirstName FROM Persons', 'SELECT Persons.FirstName', 'GET FirstName FROM Persons'], 'ans' => 'SELECT FirstName FROM Persons'],
        ['q' => "With SQL, how do you select all records where the 'City' column has the value 'Manila'?", 'opts' => ['SELECT * FROM Persons WHERE City="Manila"', 'SELECT * FROM Persons LIKE "Manila"', 'SELECT * FROM Persons City="Manila"', 'FIND Manila IN City'], 'ans' => 'SELECT * FROM Persons WHERE City="Manila"'],
        ['q' => "Which keyword is used to sort the result-set?", 'opts' => ['ORDER BY', 'SORT', 'GROUP BY', 'ARRANGE'], 'ans' => 'ORDER BY'],
        ['q' => "What is the default sorting order of the ORDER BY keyword?", 'opts' => ['Descending', 'Ascending', 'Random', 'Alphabetical'], 'ans' => 'Ascending'],
        ['q' => "With SQL, how can you return all records from a table sorted descending by 'FirstName'?", 'opts' => ['SELECT * FROM Persons ORDER BY FirstName DESC', 'SELECT * FROM Persons SORT DESC FirstName', 'SELECT * FROM Persons ORDER FirstName DESC', 'SELECT * FROM Persons DESC FirstName'], 'ans' => 'SELECT * FROM Persons ORDER BY FirstName DESC'],
        ['q' => "Which SQL statement is used to create a database table?", 'opts' => ['CREATE TABLE', 'MAKE TABLE', 'NEW TABLE', 'BUILD TABLE'], 'ans' => 'CREATE TABLE'],
        ['q' => "Which SQL statement is used to delete a table entirely?", 'opts' => ['DELETE TABLE', 'DROP TABLE', 'REMOVE TABLE', 'TRUNCATE TABLE'], 'ans' => 'DROP TABLE'],
        ['q' => "Which SQL operator is used to search for a specified pattern in a column?", 'opts' => ['MATCH', 'SEARCH', 'LIKE', 'PATTERN'], 'ans' => 'LIKE'],
        ['q' => "What is the wildcard character for zero or more characters in SQL?", 'opts' => ['*', '?', '%', '_'], 'ans' => '%'],
        ['q' => "What is the wildcard character for exactly one character in SQL?", 'opts' => ['*', '?', '%', '_'], 'ans' => '_'],
        ['q' => "How do you update the 'City' column to 'Pasig' for records where 'ID' is 1?", 'opts' => ['UPDATE Persons SET City="Pasig" WHERE ID=1', 'MODIFY Persons City="Pasig" WHERE ID=1', 'CHANGE Persons City="Pasig"', 'UPDATE City="Pasig" FROM Persons WHERE ID=1'], 'ans' => 'UPDATE Persons SET City="Pasig" WHERE ID=1'],
        ['q' => "Which keyword is used to return only distinct (different) values?", 'opts' => ['UNIQUE', 'DIFFERENT', 'DISTINCT', 'ONLY'], 'ans' => 'DISTINCT'],
        ['q' => "What keyword is used to define the boundaries of a transaction?", 'opts' => ['START / STOP', 'BEGIN / COMMIT', 'OPEN / CLOSE', 'INIT / END'], 'ans' => 'BEGIN / COMMIT']
    ];

    $dbMedium = [
        ['q' => "What does 'ACID' stand for in database design?", 'opts' => ['Atomicity, Consistency, Isolation, Durability', 'Availability, Consistency, Integrity, Durability', 'Atomic, Consistent, Isolated, Data', 'All Conditions In Data'], 'ans' => 'Atomicity, Consistency, Isolation, Durability'],
        ['q' => "Which keyword is used to sort the result-set?", 'opts' => ['SORT BY', 'ORDER BY', 'ARRANGE', 'GROUP BY'], 'ans' => 'ORDER BY'],
        ['q' => "What is the purpose of a PRIMARY KEY?", 'opts' => ['To encrypt the table', 'To uniquely identify each record in a table', 'To link to another database', 'To allow null values'], 'ans' => 'To uniquely identify each record in a table'],
        ['q' => "Which SQL function returns the number of rows that matches a specified criterion?", 'opts' => ['SUM()', 'TOTAL()', 'COUNT()', 'MAX()'], 'ans' => 'COUNT()'],
        ['q' => "If you have a user table with a 'username' column, how do you find all users whose name starts with 'a'?", 'opts' => ["WHERE username LIKE 'a%'", "WHERE username = 'a*'", "WHERE username LIKE '%a'", "WHERE username MATCH 'a'"], 'ans' => "WHERE username LIKE 'a%'"],
        ['q' => "How do you select records where the value of the City column is NOT 'Paris'?", 'opts' => ["WHERE City != 'Paris'", "WHERE City NOT 'Paris'", "WHERE NOT City='Paris'", "Both != and NOT are generally valid depending on the DBMS"], 'ans' => 'Both != and NOT are generally valid depending on the DBMS'],
        ['q' => "Which operator is used to select values within a range?", 'opts' => ['BETWEEN', 'WITHIN', 'RANGE', 'IN'], 'ans' => 'BETWEEN'],
        ['q' => "How do you select records where the 'City' is 'Paris' OR 'London'?", 'opts' => ["WHERE City IN ('Paris', 'London')", "WHERE City = 'Paris' AND 'London'", "WHERE City BETWEEN 'Paris' AND 'London'", "WHERE City LIKE 'Paris' OR 'London'"], 'ans' => "WHERE City IN ('Paris', 'London')"],
        ['q' => "What is the purpose of the GROUP BY statement?", 'opts' => ['To group rows that have the same values into summary rows', 'To order the table by a specific column', 'To join two tables together', 'To create a new table from existing data'], 'ans' => 'To group rows that have the same values into summary rows'],
        ['q' => "Which SQL function is used to return the highest value in a column?", 'opts' => ['HIGHEST()', 'MAX()', 'TOP()', 'PEAK()'], 'ans' => 'MAX()'],
        ['q' => "Which SQL function calculates the average value of a numeric column?", 'opts' => ['AVERAGE()', 'MEAN()', 'AVG()', 'MEDIAN()'], 'ans' => 'AVG()'],
        ['q' => "What does the `LIMIT` clause do in MySQL?", 'opts' => ['Constrains the data type', 'Restricts the number of rows returned by the query', 'Stops the database engine', 'Limits the execution time'], 'ans' => 'Restricts the number of rows returned by the query'],
        ['q' => "Which command is used to remove all records from a table, but keeps the table structure intact?", 'opts' => ['DROP', 'DELETE ALL', 'TRUNCATE', 'ERASE'], 'ans' => 'TRUNCATE'],
        ['q' => "What does DDL stand for?", 'opts' => ['Data Definition Language', 'Data Deletion Language', 'Dynamic Data Logic', 'Database Design Language'], 'ans' => 'Data Definition Language'],
        ['q' => "What does DML stand for?", 'opts' => ['Data Manipulation Language', 'Database Modification Logic', 'Dynamic Mapping Layer', 'Data Management Language'], 'ans' => 'Data Manipulation Language'],
        ['q' => "In an online casino database named 'Aurum', what data type is best suited for storing high-stakes currency balances accurately?", 'opts' => ['FLOAT', 'DECIMAL', 'VARCHAR', 'INT'], 'ans' => 'DECIMAL'],
        ['q' => "Which constraint ensures that a column cannot have a NULL value?", 'opts' => ['UNIQUE', 'NOT NULL', 'PRIMARY KEY', 'CHECK'], 'ans' => 'NOT NULL'],
        ['q' => "What is an Index used for in SQL?", 'opts' => ['To slow down updates', 'To create a backup', 'To retrieve data from the database very fast', 'To encrypt columns'], 'ans' => 'To retrieve data from the database very fast'],
        ['q' => "Which keyword is used to change the structure of an existing table (like adding a column)?", 'opts' => ['MODIFY TABLE', 'UPDATE TABLE', 'ALTER TABLE', 'CHANGE TABLE'], 'ans' => 'ALTER TABLE'],
        ['q' => "What happens if you use the DELETE statement without a WHERE clause?", 'opts' => ['It deletes the first row', 'It deletes the last row', 'It throws an error', 'It deletes all rows in the table'], 'ans' => 'It deletes all rows in the table']
    ];

    $dbHard = [
        ['q' => "Which join returns all records from the left table, and the matched records from the right table?", 'opts' => ['INNER JOIN', 'LEFT JOIN', 'RIGHT JOIN', 'FULL OUTER JOIN'], 'ans' => 'LEFT JOIN'],
        ['q' => "What is a 'Foreign Key'?", 'opts' => ['A key from another database', 'A field in one table that uniquely identifies a row of another table', 'An encrypted password field', 'A column that automatically increments'], 'ans' => 'A field in one table that uniquely identifies a row of another table'],
        ['q' => "Which clause is used in SQL to filter the results of a GROUP BY operation?", 'opts' => ['WHERE', 'FILTER', 'HAVING', 'EXCEPT'], 'ans' => 'HAVING'],
        ['q' => "What is 'Normalization' in databases?", 'opts' => ['Organizing data to reduce redundancy and improve integrity', 'Backing up the database', 'Writing queries in lowercase', 'Converting all data types to text'], 'ans' => 'Organizing data to reduce redundancy and improve integrity'],
        ['q' => "What is an SQL Trigger?", 'opts' => ['A button on the UI', 'A special type of stored procedure that automatically runs when an event occurs', 'An error message', 'A tool to restart the database'], 'ans' => 'A special type of stored procedure that automatically runs when an event occurs'],
        ['q' => "Which join returns only records that have matching values in BOTH tables?", 'opts' => ['OUTER JOIN', 'LEFT JOIN', 'INNER JOIN', 'CROSS JOIN'], 'ans' => 'INNER JOIN'],
        ['q' => "What does a CROSS JOIN do?", 'opts' => ['Matches records exactly', 'Produces the Cartesian product of the two tables', 'Joins tables on multiple columns', 'Fails if there are nulls'], 'ans' => 'Produces the Cartesian product of the two tables'],
        ['q' => "If your prof requirements state that a student schema must strictly prevent duplicate Student Numbers, which constraint must be applied?", 'opts' => ['CHECK', 'UNIQUE', 'INDEX', 'DEFAULT'], 'ans' => 'UNIQUE'],
        ['q' => "What is a View in SQL?", 'opts' => ['A GUI tool', 'A virtual table based on the result-set of an SQL statement', 'A backup file', 'A physical copy of a table'], 'ans' => 'A virtual table based on the result-set of an SQL statement'],
        ['q' => "What is a Stored Procedure?", 'opts' => ['A prepared SQL code that you can save, so the code can be reused', 'A manual data entry method', 'An automatic backup schedule', 'A trigger that fires on DELETE'], 'ans' => 'A prepared SQL code that you can save, so the code can be reused'],
        ['q' => "In normal forms, what does 1NF require?", 'opts' => ['No foreign keys', 'Atomic (indivisible) values in each column', 'No primary keys', 'Three separate tables'], 'ans' => 'Atomic (indivisible) values in each column'],
        ['q' => "What is a Subquery?", 'opts' => ['A query nested inside another query', 'A query that runs in the background', 'A query that fails', 'A query used only for views'], 'ans' => 'A query nested inside another query'],
        ['q' => "Which operator is used to combine the result sets of two or more SELECT statements, removing duplicates?", 'opts' => ['JOIN', 'MERGE', 'UNION', 'COMBINE'], 'ans' => 'UNION'],
        ['q' => "What is the difference between UNION and UNION ALL?", 'opts' => ['No difference', 'UNION ALL keeps duplicates, UNION removes them', 'UNION keeps duplicates, UNION ALL removes them', 'UNION ALL is faster but less secure'], 'ans' => 'UNION ALL keeps duplicates, UNION removes them'],
        ['q' => "Which function allows you to perform IF/THEN logic within an SQL SELECT query?", 'opts' => ['IF_THEN()', 'SWITCH', 'CASE', 'CONDITION'], 'ans' => 'CASE'],
        ['q' => "If 'Aurum' casino needs a table schema where the 'transaction_id' automatically generates the next number, what attribute is used in MySQL?", 'opts' => ['AUTO_INCREMENT', 'SERIAL', 'NEXT_VAL', 'GENERATE_ID'], 'ans' => 'AUTO_INCREMENT'],
        ['q' => "What does the `ROLLBACK` command do?", 'opts' => ['Restarts the database server', 'Undoes transactions that have not yet been saved to the database', 'Deletes the last row inserted', 'Restores from a backup file'], 'ans' => 'Undoes transactions that have not yet been saved to the database'],
        ['q' => "What is a deadlock in a database?", 'opts' => ['When the server crashes', 'When two or more transactions indefinitely wait for each other to release locks', 'When a query takes too long', 'When the disk is full'], 'ans' => 'When two or more transactions indefinitely wait for each other to release locks'],
        ['q' => "Which isolation level prevents 'dirty reads'?", 'opts' => ['READ UNCOMMITTED', 'READ COMMITTED', 'Both', 'Neither'], 'ans' => 'READ COMMITTED'],
        ['q' => "What is a composite primary key?", 'opts' => ['A key made of numbers and letters', 'A primary key made from two or more columns', 'A foreign key and primary key mixed', 'A key that changes daily'], 'ans' => 'A primary key made from two or more columns']
    ];

    $pools = [
        'Web Programming' => ['easy' => $webEasy, 'medium' => $webMedium, 'hard' => $webHard],
        'App Development' => ['easy' => $appEasy, 'medium' => $appMedium, 'hard' => $appHard],
        'Integrative Programming' => ['easy' => $intEasy, 'medium' => $intMedium, 'hard' => $intHard],
        'Advance Database' => ['easy' => $dbEasy, 'medium' => $dbMedium, 'hard' => $dbHard]
    ];
    
    return $pools[$subject][$difficulty] ?? [];
}
?>