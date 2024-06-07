# AI Smart Suggestions

Welcome to the AI Smart Suggestions Plugin repository. This WordPress plugin leverages AI capabilities to provide intelligent text suggestions for headings and paragraphs in the Gutenberg editor. At the moment [Groq](https://console.groq.com/docs/quickstart) is the only AI provider supported by this plugin. The plugin aims to enhance writing quality and assist users in creating engaging content efficiently.

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Configuration](#configuration)
- [Roadmap](#roadmap)
- [Contributing](#contributing)
- [License](#license)
- [Contact](#contact)

## Features

- **Writing Assistance**: Provides suggestions to improve grammar, style, and readability.
- **Content Enrichment**: Suggests engaging content based on the user's writing style and preferences.
- **User-Friendly Interface**: Seamlessly integrates with the Gutenberg editor.
- **Refreshed Suggestions**: Users can refresh and get new suggestions for their writing.

## Installation

### Prerequisites

Before you begin, ensure you have met the following requirements:

- WordPress 6.2 or higher
- PHP 7.4 or higher
- Node.js 18.12.0 or higher
- You have installed Docker and added support for Docker Compose commands. Instructions are available [here](https://docs.docker.com/compose/install/).
- You have installed GNU Make utility, which is commonly used to automate the build process of software projects. Make is often pre-installed if you're using a Unix-like system (such as Linux or macOS). Run this command to verify the installation: make --version

### Steps

1. Clone the repository to your local WordPress plugins directory:
```sh
git clone https://github.com/hasukmistry/ai-smart-suggestions.git wp-content/plugins/ai-smart-suggestions
```

2. Run the following commands to install the plugin and its dependencies:
```sh
composer install --no-dev --optimize-autoloader
composer dump-autoload -o
```

3. Run the following command to install the required npm dependencies:
```sh
npm install
```

4. Run the following command to build the plugin:
```sh
npm run build
```

5. Navigate to the WordPress dashboard, go to the 'Plugins' section, and activate the AI Smart Suggestions Plugin.

6. Navigate to the WordPress dashboard, go to the 'Settings' section, and click on the 'Smart Suggestions'. Configure your [Groq API key](https://console.groq.com/keys) and other settings as needed. Get up and running with AI Smart Suggestions!