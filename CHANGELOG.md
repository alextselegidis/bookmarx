# Release Notes

## [Unreleased]

### Added

- Add page leave prompt for saving missing data 

### Changed

- Delete link now returns to the dashboard page after deletion
- About page content updated and GitHub link added
- Locale selection is now a dropdown list in settings
- Card footers now have a different background color for better separation
- Improved gray colors and overall styling for better accessibility
- Removed secondary content titles where breadcrumbs are present
- Added proper breadcrumb support throughout the application
- Dates are now formatted based on the selected locale
- Link details page now shows the image or favicon of the page
- Tag details page lists connected (non-archived, paginated) links
- Link and label colors are now visually distinct
- Footer link now points to the Bookmarx GitHub page
- Removed "View Tag", "Edit Tag", etc. titles from pages in favor of breadcrumbs
- All view/edit pages now have proper breadcrumb navigation
- Default locale and timezone are now set from Laravel config during initial migration

## [1.0.0] - 2026-02-04

### Added
- Add account management support to the app (#1)
- Add support for global settings (#2)
- Allow multiple users with their own data (#3)
- Add links CRUD page (#4)
- Add tags CRUD page (#5)
- Create dashboard page for listing all the links (#6)
