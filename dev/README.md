# Developer Tools (dev/)

This folder contains development utilities and helper scripts. Development harnesses and E2E runners were removed from this repository to keep the root project lightweight.

Quick start
-----------

Note about production vs. development
-----------------------------------

The production site (https://webdev-tools.info/) runs as a standard PHP/Apache site and **does not rely on Node.js or npm**. Any Node/npm scripts or tools in this repository are developer conveniences only and are optional for running the site on a production host.

1. Start a lightweight local PHP server (project root is docroot):

	```bash
	# from the project root
	./dev/start-server.sh
	# or use custom host/port
	HOST=0.0.0.0 PORT=8080 ./dev/start-server.sh
	```

2. Run minimal server-side checks (PHP CLI):

	```bash
	php tests/run.php
	```

Notes
-----
- The PHP built-in server is intended for local development only — for production use a full webserver (Apache/Nginx).
- The router (`dev/router.php`) ensures missing routes are forwarded to `index.php`, which mirrors typical Apache behaviour.

