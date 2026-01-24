# Flight Schedule Web Page

A single-page web application displaying flight schedules for domestic (Philippines) and international flights using PHP DateTime functions.

## Project Structure

```
.
├── index.php          # Main page with flight schedule display
├── css/
│   └── style.css      # Stylesheet with modern card grid layout
├── images/            # Folder for flight images (optional)
├── includes/          # Folder for PHP includes (if needed)
└── README.md          # This file
```

## Features

### Required Features ✅
- **5 Domestic Flights** (Philippines routes)
- **5 International Flights** (various countries)
- **PHP DateTime Functions Used:**
  - `DateTime` - for creating date/time objects
  - `DateTimeZone` - for timezone handling
  - `format()` - for displaying formatted dates/times
  - `modify()` / `add()` with `DateInterval` - for calculating arrival times
  - `diff()` - for calculating flight duration

### Display Information
Each flight card shows:
- Flight Number (e.g., PR 2831)
- Airline name
- Origin → Destination (with airport codes)
- Departure Date & Time (with timezone)
- Arrival Date & Time (with timezone)
- Duration (computed using diff())
- Timezone labels (Asia/Manila, Asia/Tokyo, etc.)

### Bonus Features ✅
- **Countdown Timer**: Shows "Departs in X minutes" for upcoming flights
- **Status Badge**: Displays On Time / Boarding / Departed status
- **Other Timezones Section**: Shows current time in 3 different timezones

## Design Features

- Modern card-based grid layout using CSS Grid
- Responsive design (works on mobile and desktop)
- Hover effects on cards
- Clean, organized layout with header, main, and footer sections
- Gradient background
- Rounded corners (border-radius) on cards
- Proper spacing and padding throughout

## Timezones Used

- **Domestic**: Asia/Manila (all domestic flights)
- **International**: 
  - Asia/Tokyo (Japan)
  - Asia/Singapore (Singapore)
  - Asia/Seoul (South Korea)
  - Asia/Hong_Kong (Hong Kong)
  - Asia/Bangkok (Thailand)

## How to Run

1. Place all files in a web server directory (e.g., `htdocs`, `www`, or use PHP built-in server)
2. Ensure PHP 7.0+ is installed
3. Access `index.php` through your web browser
4. For local testing, you can use: `php -S localhost:8000`

## PHP Requirements

- PHP 7.0 or higher
- DateTime extension (usually enabled by default)

## Notes

- Flight times are calculated dynamically using PHP DateTime functions
- The countdown and status are based on the current server time
- All times are displayed in their respective timezones
- Card images use emoji placeholders (you can replace with actual images in the `images/` folder)
