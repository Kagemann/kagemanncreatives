# Kagemann Creatives

A production-ready WordPress system for Kagemann Creatives, a small web bureau aimed at SMB websites.

## Repository Structure

This mono-repo contains:

- **`wp-starter/`** → Reusable WordPress starter kit (block theme child, MU plugins, SOP docs)
- **`bureau-site/`** → Kagemann Creatives marketing site (using the starter kit)
- **`docs/`** → SOPs, client templates, launch and care checklists
- **`tooling/`** → CI, linting, scripts to spin up new client projects

## Quick Start

```bash
# Check system requirements
make doctor

# Create a new client site
make new-client CLIENT=acme

# Format code
make fmt

# Sync documentation
make sync-docs
```

## Architecture

The system is designed for:
- **Speed**: Optimized WordPress with minimal dependencies
- **Repeatability**: Consistent starter kit for all client projects
- **Maintainability**: Clean code with comprehensive documentation
- **EU Compliance**: Built-in privacy and cookie consent features

## Future Expansion

The architecture supports adding new tech stacks (e.g., `shopify-starter/`) as sibling folders without disrupting existing functionality.

## License

MIT License - See [LICENSE](LICENSE) for details.

## Support

For questions or issues, please refer to the documentation in the `docs/` directory or contact Kagemann Creatives.
