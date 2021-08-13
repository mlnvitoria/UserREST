# The ".NET Core Project"

Built with [.NET CORE 5](https://docs.microsoft.com/pt-br/aspnet/core/?view=aspnetcore-5.0)!

ASP.NET Core is the open-source version of ASP.NET, that runs on macOS, Linux, and Windows. ASP.NET Core was first released in 2016 and is a re-design of earlier Windows-only versions of ASP.NET.

## Documentation
You can check our API documentation at [Internal Swagger (/swagger)](https://localhost:44312/swagger/index.html).

## Local Environment

Make sure you have installed the following packages for this project:
* Microsoft.AspNetCore.Authentication v2.2.0
* Microsoft.EntityFrameworkCore v5.0.9
* Microsoft.EntityFrameworkCore.SqlServer v5.0.9
* Microsoft.EntityFrameworkCore.Tools v5.0.9
* Swashbuckle.AspNetCore v5.6.3

For this development, it was used IIS Express by Visual Studio 2019.

### Database Settings
Set your database info at `appsettings.Development.json` with your Database Schema like this:
```code
"ConnectionStrings": {
    "ProjectDbContext": "Server=(localdb)\\mssqllocaldb;Database=NETCoreProject;Trusted_Connection=True;MultipleActiveResultSets=true"
  }
```