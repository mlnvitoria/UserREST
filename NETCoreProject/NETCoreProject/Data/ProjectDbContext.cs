using Microsoft.EntityFrameworkCore;
using NETCoreProject.Models;

namespace NETCoreProject.Data
{
    public class ProjectDbContext : DbContext
    {
        public ProjectDbContext(DbContextOptions<ProjectDbContext> options) : base(options) { }
        public DbSet<User> User { get; set; }
        public DbSet<Customer> Customer { get; set; }

        protected override void OnModelCreating(ModelBuilder modelBuilder)
        {
            modelBuilder.Entity<Customer>().HasQueryFilter(e => e.DeletedAt == null);
            modelBuilder.Entity<User>().HasQueryFilter(e => e.DeletedAt == null);
        }
    }
}
