# Sh99 CLI
A server management cli for bungeecord.

##Requirements
• PHP 7+

## Installation

Put the `sh99.php` file in your main bungeecord directory. 
Also put the `/cli/` folderin there.

Make sure you have installed PHP and run the php file with params and flags.

## Usage
There are a few params you can use to manage your bungeecord server.
Before using a command you always need to call php on cli.

---

**Updating a plugin to all bungeecord server**

Unsafe: `php -f sh99.php update`

Safe: `php -f sh99.php update --bk`

---

**Flags**

You can append different flags to the command end.

---

Create a backup from your whole bungeecord-project with `--bk` or `--backup`

