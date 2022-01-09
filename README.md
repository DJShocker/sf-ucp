
<!-- PROJECT LOGO -->
<br />
<p align="center">
  <a href="https://sfcnr.com">
    <img src="https://i.imgur.com/Yzq9JiT.png" alt="Logo" width="128" height="128">
  </a>

  <h3 align="center">San Fierro Cops And Robbers</h3>
  <h4 align="center">User Control Panel (UCP) v4.6.0</h4>

</p>

<!-- TABLE OF CONTENTS -->
## Table of Contents

* [About the Project](#about-the-project)
* [Getting Started](#getting-started)
* [Previews](#previews)
* [License](#license)
* [Contact](#contact)

<!-- ABOUT THE PROJECT -->
## About The Project

This project is User Control Panel web application for the [SF-CNR project](https://github.com/zeelorenc/sf-cnr).

This project is over 6 years old. It is old code and certainly **not recommended for a production** environment given that it has been unmaintained for years. But due to overwhelming demand, it has been open sourced should you want to use it for anything.

Some features may or may not work. Mostly data related issues, and no guaranteed fix may be provided the project is now discontinued.

Built using the Laravel 4.2 php framework at the time.

<!-- GETTING STARTED -->
## Getting Started

This project has been dockerized for convienience. Make sure your server/system has docker installed.

1. Clone the project
2. `cp .env.example.php .env.php`
3. Edit `.env.php` and make sure the database point to your SF-CNR database
4. `docker compose up -d --build`
	* By default, the port used will be 80. Modifiable in the docker-compose (see nginx, ports section - 80:80 is default, but 8080:80 will use port 8080 instead).
5. `docker exec sf-ucp_app composer install`
6. Access the site `http://localhost`

<!-- PREVIEWS EXAMPLES -->
## Previews
![Login Page](https://i.imgur.com/Y8i89Uy.png)
![Dashboard](https://i.imgur.com/oWJHsac.png)

<!-- LICENSE -->
## License

Distributed under the MIT License. See `LICENSE` for more information.

<!-- CONTACT -->
## Contact

Lorenc - [@zeelorenc](https://twitter.com/zeelorenc) - zeelorenc@hotmail.com

Project Link: [https://github.com/zeelorenc/sf-ucp](https://github.com/zeelorenc/sf-ucp)
