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

## Usage

1. **Activate the Plugin**: Ensure the plugin is activated from the WordPress plugins dashboard.
2. **Create or Edit a Post**: Open the Gutenberg editor by creating a new post or editing an existing one.
3. **Receive Suggestions**: Start typing in a heading or paragraph block. New icon will appear on the block toolbar to show the Smart Suggestions.
4. **Smart Suggestions**: Click on the Smart Suggestions icon, It will show a modal with suggestions for the current text. You can choose the suggested text and apply it to the block. Or you can click on the 'Refresh' button to get new suggestions.

## Configuration

Navigate to the plugin settings page under 'Settings > Smart Suggestions' to configure:

- **AI Provider**: Select the AI provider you want to use. Currently, only Groq is supported.
- **AI Model**: Select the AI model you want to use. Groq offers several [models](https://console.groq.com/docs/models), such as 'LLaMA3 8b', 'LLaMA3 70b', 'Mixtral 8x7b', and 'Gemma 7b'.
- **API Key**: Enter your [Groq API key](https://console.groq.com/keys).

## Roadmap

- **v1.0**: Initial release with Groq as the only AI provider. Suggestions are provided for headings and paragraphs.

## Contributing

Contributions are welcomed from the community! To contribute:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Make your changes and commit them (`git commit -m 'Add new feature'`).
4. Push to the branch (`git push origin feature-branch`).
5. Create a new Pull Request.

Please ensure all changes adhere to the project's coding standards. Use the following commands to run the linter:
```
npm run lint:js
composer phpcs
```

## License

This project is licensed under the GNU General Public License version 3. See the [LICENSE](LICENSE) file for details.

## Contact

For any questions or inquiries, please contact:

- **Name**: Hasmukh Mistry
- **LinkedIn**: [hasmukh-k-mistry](https://www.linkedin.com/in/hasmukh-k-mistry/)
- **X**: [hasukmistry](https://x.com/hasukmistry)
- **Threads** [@el.happinio](https://www.threads.net/@el.happinio)

Thank you for using the AI Smart Suggestions Plugin!
