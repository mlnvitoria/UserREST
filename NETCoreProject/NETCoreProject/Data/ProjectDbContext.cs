using Microsoft.EntityFrameworkCore;
using NETCoreProject.Models;

namespace NETCoreProject.Data
{
    public class ProjectDbContext : DbContext
    {
        public ProjectDbContext(DbContextOptions<ProjectDbContext> options) : base(options) { }
        public DbSet<User> User { get; set; }
        public DbSet<Customer> Customer { get; set; }
    }
}
